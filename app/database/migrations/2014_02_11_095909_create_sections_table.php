<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sections', function($table)
        {
            $table->increments('id');
            $table->string('number', 6);
            $table->text('content');
            $table->integer('votes')->unsigned()->default(0);
            $table->integer('law_id')->unsigned();
            $table->foreign('law_id')->references('id')->on('laws');
            $table->softDeletes();
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
		Schema::drop('sections');
	}

}
