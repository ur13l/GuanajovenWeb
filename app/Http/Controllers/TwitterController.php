<?php

namespace App\Http\Controllers;



use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;


class TwitterController extends Controller
{

    public function obtenerTweets(Request $request) {
        $consumer_key = 'zHb326FK2xT666c0olifieF9h';
        $consumer_secret = 'ImFmtlFoLNuWWFRo4yAqbUTKhdeZElZCJ0UVn48UtVj1NkwS7d';
        $access_token = '865314952470560768-BZ5AXIzHyRndtxWqcYe8u2rKMIb25cF';
        $acces_token_secret = 'cBqlyZVCekQNnCE5v4LAdDzpzOqgsdqHjocTpw26JThn4';
        $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $acces_token_secret);
        $tweets = $connection->get("search/tweets", array("q" => $request->get('screen_name')));

        return response()->json($tweets);
    }

}
