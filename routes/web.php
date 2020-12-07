<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // parameter
    $col = 4;
    $page = 3;
    $spreadsheetID = '1FHXLTwnAQRUpB_Gty4qv-eK8kBVRQXnhUYbLXlCCo5s';

    $url = 'https://spreadsheets.google.com/feeds/cells/'.$spreadsheetID.'/'.$page.'/public/full?alt=json';

    // init http request to spreadsheets
    $client = new \GuzzleHttp\Client();
    $rawData = $client->get($url);

    // return data as a JSON and retrieve content only
    $rawData = json_decode($rawData->getBody()->getContents());
    $rawData = $rawData->feed->entry;

    // restructure with object 
    $tempElement = []; 
    $result = []; 
    $counter = 0;
    foreach ($rawData as $index => $element) {
        if($counter < $col){
            $tempElement[$counter] = $element->content->{'$t'};

            if($counter == $col-1){
                array_push($result, $tempElement);
            }
        }
        else{
            $counter = 0;
            $tempElement[$counter] = $element->content->{'$t'};
        }

        $counter++;
    }

    return view(
        'welcome',
        [
            'result' => $result,
            'col' => $col
        ]
    );
});
