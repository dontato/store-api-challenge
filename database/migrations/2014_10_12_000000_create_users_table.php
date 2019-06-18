<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')
                ->comment('User\'s name');
            $table->string('email')
                ->unique()
                ->comment('Account\'s email');
            $table->timestamp('email_verified_at')
                ->nullable()
                ->comment('Account\'s verification timestamp');
            $table->string('password')
                ->comment('Account\'s encrypted password');
            $table->rememberToken()
                ->comment('Account\'s remember token');
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
        Schema::dropIfExists('users');
    }
}
