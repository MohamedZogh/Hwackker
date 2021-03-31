<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->boolean('is_admin')->default(false);
            $table->string('username');
            $table->string('profile_picture');
            $table->date('birth_date')->nullable();
            $table->string('country');
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'username' => 'momo',
                'password' => bcrypt('momo'),
                'facebook_url' => 'https://momoFB.fb.com',
                'email' => 'momo@momo.com',
                'is_admin' => true,
                'country' => 'FR',
                'profile_picture' => 'filename_momo.png'
            )
        );
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
