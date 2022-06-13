<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class AnimeApiController extends BaseController
{
    public function getTopAnime(){
        $url = "https://api.jikan.moe/v4/top/anime";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function getAnimeInfoById($id){
        $url = "https://api.jikan.moe/v4/anime/".$id;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function searchAnimeByName(){
        $request=request();
        $name=urlencode($request->query('q'));
        $url = "https://api.jikan.moe/v4/anime?q=" . $name ."&type=tv";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
