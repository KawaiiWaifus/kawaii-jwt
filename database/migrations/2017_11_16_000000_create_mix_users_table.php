<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMixUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->string('email', 120)->unique('users_email_unique');
			$table->string('password', 125);
			$table->string('remember_token', 100)->nullable();
			$table->string('telephone', 20)->nullable();
			$table->integer('active')->default(0);
			$table->string('gender', 25)->nullable();
			$table->string('address', 190)->nullable();
			$table->string('amount', 75)->nullable();
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
		Schema::drop('mix_users');
	}

}
