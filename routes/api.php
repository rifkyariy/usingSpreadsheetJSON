<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/usingSpreadsheet', function(Request $request)
{
    // parameter
    // $col = 7;
    // $page = 1;
    // $spreadsheetID = '1FHXLTwnAQRUpB_Gty4qv-eK8kBVRQXnhUYbLXlCCo5s';

    $col = $request->input('col');
    $page = $request->input('page');
    $spreadsheetID = $request->input('spreadsheetID');
    $url = 'https://spreadsheets.google.com/feeds/cells/'.$spreadsheetID.'/'.$page.'/public/full?alt=json';

    // init http request to spreadsheets
    $client = new \GuzzleHttp\Client();
    $rawData = $client->get($url);

    // return data as a JSON and retrieve content only
    $rawData = json_decode($rawData->getBody()->getContents());
    $rawData = $rawData->feed->entry;
    
    // test with resize 
    // $data = array_slice($rawData, 0, $col*3);

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

    return response()->json($result);
});