<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title');
			$table->string('description');
			$table->string('address');
			$table->string('zip');
			$table->string('country');
			$table->string('lat');
			$table->string('long');
			$table->enum('category', ['cat1','cat2']);
			$table->string('website');
			$table->date('start');
			$table->date('end');
			$table->enum('state', ['active','inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
