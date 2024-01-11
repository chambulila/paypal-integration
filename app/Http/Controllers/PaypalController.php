<?php

namespace App\Http\Controllers;

use Request;
use Inertia\Inertia;
use Auth;
use Session;
use App\Models\Task;
use App\Models\Payment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    } 


public function dashboard()
{
    return Inertia::render('Paypal/Dashboard', [
        'user' => Auth::User()->name
    ]);
}

public function createTask()
{
    return Inertia::render('Paypal/CreateTask');
}


public function tasksList()
{
    $tasks = Task::filter(Request::only('search', 'trashed'))->paginate(10)->withQueryString()->through(fn ($item, $i=0) => [
        'i' => $i += 1,
        'description' => \Str::limit($item->description, 30),
        'task' => $item->name,
        'uuid' => $item->id,
        'date' => date("d-m-Y", strtotime($item->created_at)),
        'status' => $item->status == 0 ? 'Unpaid' : ($item->status == 1 ? 'paid' : 'partial')
    ]);
    return Inertia::render('Paypal/Index', [
        'back_url' => url()->previous(),
        'tasks' => $tasks,
        'filters' => Request::all('search', 'trashed'),
    ]);
}

public function deleteTask($uuid)
{
    Task::where('id', $uuid)->first()->delete();
    return redirect()->route()->with('success', 'Task Deleted successfully');
}

public function processTransaction(Request $request)
{
    // dd(request()->all());
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalToken = $provider->getAccessToken();
    $response = $provider->createOrder([
        "intent" => "CAPTURE",
        "application_context" => [
            "return_url" => route('successTransaction'),
            "cancel_url" => route('cancelTransaction'),
        ],
        "purchase_units" => [
            0 => [
                "amount" => [
                    "currency_code" => "USD",
                    "value" => request('price')
                ]
            ]
        ]
    ]);
    // dd($response['id']);
    if (isset($response['id']) && $response['id'] != null) {
        Session::put('description', request('description'));
        Session::put('task_name', request('task'));
        Session::put('user', request('user'));
        Session::put('currency_type', request('currency_type'));

        // redirect to approve href
        foreach ($response['links'] as $links) {
            if ($links['rel'] == 'approve') {
                return redirect()->away($links['href']);
            }
        }
        return redirect()->route('createTransaction')->with('error', 'Something went wrong.');
    } else {
        return redirect()->route('createTransaction')->with('error', $response['message'] ?? 'Something went wrong.');
    }
}

public function successTransaction(Request $request)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();
    $response = $provider->capturePaymentOrder(request()['token']);

    if (isset($response['status']) && $response['status'] == 'COMPLETED') {
     try {
        Task::create([
            'name' => Session::get('task_name'),
            'user' => Session::get('user'),
            'status' => $response['status'],
            'currency_type' => Session::get('currency_type'),
            'description' => Session::get('description'),
            'uuid' => uniqid(),
        ]);
        
        unset($_SESSION['description']);
        unset($_SESSION['task_name']);
        unset($_SESSION['currency_type']);

        Payment::create([
            'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
            'currency' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
            'task_id' => Task::latest()->first()->id,
            'quantity' => 1,
            'method' => "PayPal",
            'payer' => $response['payer']['name']['given_name'],
            'payer_address' => $response['payer']['email_address'],
            'status' => $response['status'] 
        ]);
    

        return redirect()->route('createTransaction', ['openInNewTab' => true])->with('success', 'Transaction complete.');
    } catch (\Exception $th) {
        dd($th->getMessage());
     }

    } else {
        return redirect()->route('createTransaction')->with('error', $response['message'] ?? 'Something went wrong.');
    }
}

public function paymentList()
{
    dd(23);
    $payments = Payment::filter(Request::only('search', 'trashed'))->paginate(10)->withQueryString()->through(fn ($item, $i=0) => [
        'i' => $i += 1,
        'amount' => $item->amount,
        'currency' => $item->currency,
        'method' => $item->method,
        'payer' => $item->payer,
        'payer_address' => $item->payer_address,
        'task' => $item->task->name,
        'date' => date("d-m-Y", strtotime($item->created_at)),
        'status' => $item->status
    ]);
    return Inertia::render('Payment/Index', [
        'back_url' => url()->previous(),
        'payments' => $payments,
        'payment_count' => Payment::get()->count(),
        'filters' => Request::all('search', 'trashed'),
    ]);
}

public function cancelTransaction(Request $request)
{
    return redirect()->route('createTransaction')->with('error', $response['message'] ?? 'You have canceled the transaction.');
}

}
