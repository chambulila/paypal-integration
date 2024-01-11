@extends('layouts.auth')
@section('content')
	<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
		<div>
			<center>
				<img src="{{ asset('NIT_logoBg.png') }}" alt="" width="10%">
				<span class="uppercase font-bold">nit leave request management system</span>
			</center>
	</div>

		<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
			<!-- Validation Errors -->
			@if ($errors->any())
				<div class="mb-4">
					<div class="font-medium text-red-600">
						{{ __('Whoops! Something went wrong.') }}
					</div>

					<ul class="mt-3 list-disc list-inside text-sm text-red-600">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('password.update') }}">
			@csrf

			<!-- Password Reset Token -->
				<input type="hidden" name="token" value="{{ $request->route('token') }}">

				<!-- Email Address -->
				<div>
					<label for="email" class="block font-medium text-sm text-gray-700">
						{{ __('Email') }}
					</label>

					<input id="email" name="email" type="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('email', $request->email) }}" required autofocus>
				</div>

				<!-- Password -->
				<div class="mt-4">
					<label for="password" class="block font-medium text-sm text-gray-700">
						{{ __('Password') }}
					</label>

					<input id="password" name="password" type="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
				</div>

				<!-- Confirm Password -->
				<div class="mt-4">
					<label for="password_confirmation" class="block font-medium text-sm text-gray-700">
						{{ __('Confirm Password') }}
					</label>

					<input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
				</div>

				<div class="flex items-center justify-end mt-4">
					<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
						{{ __('Reset Password') }}
					</button>
				</div>
			</form>
		</div>
	</div>
@endsection