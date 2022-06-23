<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('theme', 300)->nullable();
            $table->mediumText('description')->nullable();
            $table->date('deadline')->nullable();
            $table->string('level', 300)->nullable();
            $table->string('applicants', 300)->nullable();
            $table->string('contact', 300)->nullable();
            $table->mediumText('comments')->nullable();
            $table->datetime('filling_date')->nullable();
            $table->string('status', 300)->nullable();
            $table->datetime('decision_date')->nullable();
            $table->mediumText('decision_comments')->nullable();
            $table->string('file', 300)->nullable();
            $table->longText('extras')->nullable();
            $table->timestamps();
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
