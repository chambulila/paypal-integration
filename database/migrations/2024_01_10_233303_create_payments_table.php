<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{

    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->foreignId('task_id')->constrained();
            $table->string('quantity');
            $table->string('currency');
            $table->string('method');
            $table->string('payer');
            $table->string('status');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
