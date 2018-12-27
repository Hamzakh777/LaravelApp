<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //table name
    protected $table = 'posts';
    // timestamps
    public $timestamps = true;

    // this is saying that a post has a relationship with a user, where each post belongs to a user
    public function user() {
        return $this->belongsTo('App\User');
    }
}
