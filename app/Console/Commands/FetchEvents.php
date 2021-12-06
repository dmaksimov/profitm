<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
// use GuzzleHttp\Client;

class FetchEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching page events of facebook';

    public $adapter;
    public $config;
    public $guzzle;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $responses = $this->getResponse();
        foreach($responses as $response)
        {
            Event::updateOrCreate(
                ['event_id' =>  $response->id],
                ['title' => @$response->name,'description' => @$response->description,'start_time' => @$response->start_time,'end_time' => @$response->end_time,'response' => @$response]
            );
        }
    }

    public function getResponse(){
        $URL  = 'https://graph.facebook.com/v3.0/'.env('FACEBOOK_PAGE_ID').'/events/attending/?access_token='.env('FACEBOOK_APP_ACCESS_TOKEN');
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $URL);
        curl_setopt($curlHandle, CURLOPT_HEADER, true);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curlHandle);
        $header_size = curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);
        curl_close($curlHandle);
        return json_decode($body)->data;
    }
}
