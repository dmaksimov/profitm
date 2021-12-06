<?php

namespace App\Console\Commands;

use App\Models\FacebookCampaign;
use Illuminate\Console\Command;

class FetchCamapaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Faacebook Campaings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function handle()
    {
        $responses = $this->getResponse()['response'];
        if($this->getResponse()['status'])
        {
            foreach($responses as $response)
            {
                FacebookCampaign::updateOrCreate(
                    ['facebook_campaign_id' =>  $response->id],
                    ['title' => @$response->name,'updated_date' => @$response->updated_time,'start_date' => @$response->start_time,'end_date' => @$response->stop_time,'response' => @$response,'status' => @$response->status]
                );
            }
            echo "Successfully fetched";
        } else {
            echo $responses;
        }
        
    }

    public function getResponse(){

        try {
            $URL  = 'https://graph.facebook.com/v10.0/act_'.env('FACEBOOK_ACCT_ID').'/campaigns?access_token='.env('FACEBOOK_APP_ACCESS_TOKEN').'&fields=id,name,created_time,start_time,stop_time,status,updated_time';
            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $URL);
            curl_setopt($curlHandle, CURLOPT_HEADER, true);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curlHandle);
            $header_size = curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE);
            $body = substr($response, $header_size);
            curl_close($curlHandle);
            $data['response'] = json_decode($body)->data;
            $data['status'] = true;
            return $data;
        } catch (\Exception $e) {
            $data['response'] = $e->getMessage();
            $data['status'] = false;
            return $data;
        }

        
    }
}
