<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use Session;

class DatabaseApiController extends BaseController
{
    public function checkUsername(){
        $request=request();
        $username=urldecode($request->query('q'));
        if(User::firstWhere('username',$username)){
            $finalResult["result"] = false;
        }else{
            $finalResult["result"] = true;
        }
        return $finalResult;
    }

    public function checkEmail(){
        $request=request();
        $email=urldecode($request->query('q'));
        if(User::firstWhere('email',$email)){
            $finalResult["result"] = false;
        }else{
            $finalResult["result"] = true;
        }
        return $finalResult;
    }

    public function getLikes(){
        if(!Session::get('user_id')){
            return redirect(route('index'));
        }
        $finalResult = array();
        $user = User::find(Session::get('user_id'));
        $likes = $user->likes;
        foreach($likes as $like){
            $finalResult[] = array('anime_id'=>$like->anime_id);
        }
        return $finalResult;
    }

    public function addLike($id){
        if(!Session::get('user_id')){
            return redirect(route('index'));
        }
        $finalResult["result"] = "false";
        $like = new Like;
        $like->user_id = Session::get('user_id');
        $like->anime_id = $id;
        $like->save();
        $finalResult["animeID"] = $id;
        $finalResult["result"] = "true";
        return $finalResult;
    }

    public function removeLike($id){
        if(!Session::get('user_id')){
            return redirect(route('index'));
        }
        $finalResult["result"] = "false";
        $like = Like::where('anime_id',$id)->where('user_id',Session::get('user_id'))->first();
        $like->delete();
        $finalResult["animeID"] = $id;
        $finalResult["result"] = "true";
        return $finalResult;
    }

    public function getComments($id){
        if(!Session::get('user_id')){
            return redirect(route('index'));
        }
        $comments = Comment::where('anime_id',$id)->orderBy('created_at','desc')->take(15)->get();
        $count = Comment::where('anime_id',$id)->count();
        $finalResult["items"] = $count;
        foreach($comments as $comment){
            $user = $comment->user;
            $comment['username'] = $user->username;
            $finalResult['data'][] = $comment;
        }
        return $finalResult;
    }

    public function addComment($id){
        if(!Session::get('user_id')){
            return redirect(route('index'));
        }
        $finalResult["result"] = false;
        $comment = new Comment;
        $comment->user_id = Session::get('user_id');
        $comment->anime_id = $id;
        $comment->content = request('comment');
        $comment->save();
        $finalResult["result"] = true;
        return $finalResult;
    }

}
