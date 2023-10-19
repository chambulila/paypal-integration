<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaverequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('approval_date')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('leave_type_id')->constrained();
            $table->foreignId('leave_reason_id')->constrained();
            $table->foreignId('leave_status_id')->default(0);
            $table->text('note')->nullable();
            $table->string('attachment', 200)->nullable();
            $table->string('reference', 100)->nullable();
            // $table->foreignId('school_id')->default(1)->constrained();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timeTz('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_requests');
    }
}
