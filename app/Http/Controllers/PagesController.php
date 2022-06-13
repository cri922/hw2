<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\Anime;

class PagesController extends BaseController
{
    public function index(){
        return view('index');
    }

    public function home(){
        if(Session::get('username')){
            return view('home')->with('username',Session::get('username'));
        }
        return redirect(route('login_form'));
    }

    public function anime($id){
        if(Session::get('username')){
            $url = "https://api.jikan.moe/v4/anime/".$id;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            $result = json_decode($response,true);
            curl_close($curl);
            $likes=0;
            if(($anime = Anime::find($id))){
                $likes=$anime->n_likes;
            }
            $data = strtotime($result['data']['aired']['from']);
            $data = date('j F Y',$data);
            return view('anime')->with('username',Session::get('username'))
                                ->with('result',$result)
                                ->with('likes',$likes)
                                ->with('data',$data);
        }
        return redirect(route('login_form'));
    }

    public function profile(){
        if(Session::get('username')){
            $user = User::find(Session::get('user_id'));
            return view('profile')->with('username',Session::get('username'))
                                ->with('user', [
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'username' => $user->username,
                'email' => $user->email,
            ]);
        }
        return redirect(route('login_form'));
    }

    public function deleteAccount(){
        if(Session::get('user_id')){
            $user = User::find(Session::get('user_id'));
            $user->delete();
            return redirect(route('logout'));
        }
        return redirect(route('profile'));
    }
}
