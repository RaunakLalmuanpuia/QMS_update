<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('file_path'); // New column to store file path
            $table->string('status')->nullable();
            $table->text('feedback')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employee');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
            $table->string('deleted_by_employee')->nullable();
            $table->string('deleted_by_admin')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
