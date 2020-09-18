<?php
namespace App\libraries;

use GuzzleHttp\Client;

class LiveConversionRate
{

    public $to_currency;
    public $from_currency;
    public $client;

    public function __construct($to_currency = null, $from_currency = null)
    {
        $this->to_currency = $to_currency;
        $this->from_currency = $from_currency;
        // I decided not to use Fixer as recommended due to it's free account limitations.
        // Namely being unable to set a base currency with a free account.
        $this->client = new Client(['base_uri' => 'https://api.exchangeratesapi.io/']);
    }

    public function setToCurrency($to_currency)
    {
        $this->to_currency = $to_currency;
    }

    public function setFromCurrency($from_currency)
    {
        $this->from_currency = $from_currency;
    }

    public function convertRate($rate)
    {
        $response = $this->client->request('GET', 'latest?base='.$this->from_currency.'&symbols='.$this->to_currency);

        $body = json_decode($response->getBody());

        return $body->rates->{$this->to_currency};
    }
}
