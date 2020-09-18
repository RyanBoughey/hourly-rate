<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // hourly_rate was originally intended to be an integer to avoid floating point rounding errors however, due to the very limited operation happening on this field, namely only multiplying it by the conversion rate, I decided that the extra work needed to use an integer of 1000 to store 10.00 was unnecessary in comparison to the limited risk of such errors.
            $table->float('hourly_rate')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('hourly_rate')->change();
        });
    }
}
