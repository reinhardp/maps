<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name')->unique();
			$table->char('countrycode',2);
			$table->char('iso3',3);
			$table->char('number',3);
			$table->char('currency',3);
			$table->enum('state', ['active','inactive'])->default('active');
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
        Schema::drop('countries');
    }
}
