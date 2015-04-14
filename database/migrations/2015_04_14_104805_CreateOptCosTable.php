<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptCosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('opt_subs_original_cos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ussd_session_id');
			$table->text('msisdn');
			$table->text('original_cos');
			$table->text('input');
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
		Schema::drop('opt_subs_original_cos');
	}

}
