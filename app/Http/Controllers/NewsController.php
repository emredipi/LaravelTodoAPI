<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $apiURL = 'https://newsapi.org/v2/top-headlines' .
            '?apiKey=' . env("NEWS_API_KEY") .
            '&country=tr' .
            '&category=' . $request->category;
        $response = $client->request('GET', $apiURL);
        return $response->getBody();
    }
}
