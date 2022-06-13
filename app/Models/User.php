<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  public function likes(){
    return $this->hasMany(Like::class);
  }

  public function comments(){
    return $this->hasMany(Comment::class);
  }
}
