<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversion_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_currency_id');
            $table->foreignId('to_currency_id');
            $table->float('conversion_rate', 8, 2);
            $table->timestamps();
        });

        DB::table('conversion_rates')->insert([
            'from_currency_id' => '1',
            'to_currency_id' => '2',
            'conversion_rate' => '1.3'
        ]);
        DB::table('conversion_rates')->insert([
            'from_currency_id' => '1',
            'to_currency_id' => '3',
            'conversion_rate' => '1.1'
        ]);
        DB::table('conversion_rates')->insert([
            'from_currency_id' => '2',
            'to_currency_id' => '1',
            'conversion_rate' => '0.7'
        ]);
        DB::table('conversion_rates')->insert([
            'from_currency_id' => '2',
            'to_currency_id' => '3',
            'conversion_rate' => '0.8'
        ]);
        DB::table('conversion_rates')->insert([
            'from_currency_id' => '3',
            'to_currency_id' => '1',
            'conversion_rate' => '0.9'
        ]);
        DB::table('conversion_rates')->insert([
            'from_currency_id' => '3',
            'to_currency_id' => '2',
            'conversion_rate' => '1.2'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversion_rates');
    }
}
