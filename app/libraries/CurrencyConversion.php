<?php
namespace App\libraries;

use GuzzleHttp\Client;
use App\Models\Currency;
use App\Models\ConversionRate;
use Illuminate\Support\Facades\App;

class CurrencyConversion
{

    public $to_currency;
    public $from_currency;
    public $client;

    public function __construct($to_currency = null, $from_currency = null)
    {
        if ($to_currency !== null) {
            $this->to_currency = Currency::find($to_currency);
        }
        if ($from_currency !== null) {
            $this->from_currency = Currency::find($from_currency);
        }
        if (App::environment('local')) {
            // The environment is local, and so we will use the local database rates
            $this->client = 'local';
        } else {
            // The environment is not local, and so we will use the live conversion rates
            // I decided not to use Fixer as recommended due to it's free account limitations.
            // Namely being unable to set a base currency with a free account.
            $this->client = new Client(['base_uri' => 'https://api.exchangeratesapi.io/']);
        }
    }

    public function setToCurrency($to_currency)
    {
        $this->to_currency = Currency::find($to_currency);
    }

    public function setFromCurrency($from_currency)
    {
        $this->from_currency = Currency::find($from_currency);
    }

    public function convertRate($rate)
    {
        if ($this->client == 'local') {
            $conversion = ConversionRate::where([
                ['from_currency_id', $this->from_currency->id],
                ['to_currency_id', $this->to_currency->id]
            ])->first();
            $conversion_rate = $conversion->conversion_rate;
        } else {
            $response = $this->client->request(
                'GET',
                'latest?base='.$this->from_currency->name.'&symbols='.$this->to_currency->name
            );
            $body = json_decode($response->getBody());
            $conversion_rate = $body->rates->{$this->to_currency->name};
        }
        $converted_rate = $rate * $conversion_rate;
        return $converted_rate;
    }
}
