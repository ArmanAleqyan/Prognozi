<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Webmasters;
use Google_Service_Webmasters_UrlCrawlErrorsSamples;

use Google_Service_Indexing;
use Google_Service_Indexing_UrlNotification;
use GuzzleHttp\Client;
class IndexingController extends Controller
{
    public function indexing(){

        $client = new Google_Client();
        $client->setApplicationName('deja');
        $client->setAuthConfig(public_path('red-charger-400016-9cd9a6892c71.json'));
        $client->addScope(Google_Service_Webmasters::WEBMASTERS);





        $service = new Google_Service_Indexing($client);


        $url = 'https://aisportsoracle.com/bet/las-palmas-granada-24-09-2023/88';

        $notification = new Google_Service_Indexing_UrlNotification();
        $notification->setUrl($url);




        $response = $service->urlNotifications->publish($notification);

        if ($response->getResponseCode() == 200) {
            return 'URL успешно отправлен на индексацию.';
        } else {
            return 'Произошла ошибка при отправке URL на индексацию.';
        }



//        $client = new Google_Client();
//        $client->setApplicationName('deja');
//        $client->setAuthConfig(public_path('red-charger-400016-9cd9a6892c71.json'));
//        $client->addScope('https://www.googleapis.com/auth/indexing');
//
//
//
//        $httpClient = $client->authorize();
//        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
//
//
//            $content = '{
//              "url": "https://aisportsoracle.com",
//             "type": "URL_UPDATED"
//            }';
//
//        $response = $httpClient->post($endpoint, [ 'body' => $content ]);
//        $status_code = $response->getStatusCode();
//
//        dd($response->getReasonPhrase());
//        if ($response->getResponseCode() == 200) {
//            return 'URL успешно отправлен на индексацию.';
//        } else {
//            return 'Произошла ошибка при отправке URL на индексацию.';
//        }

    }
}
