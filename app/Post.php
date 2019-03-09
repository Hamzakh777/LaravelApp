<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // So the model is the class tied to a certain table in the db
    //table name
    protected $table = 'posts';
    // timestamps
    public $timestamps = true;

    // this is saying that a post has a relationship with a user, where each post belongs to a user
    public function user() {
        return $this->belongsTo('App\User');
    }
    // The following is saying which fields are okay to reassigne
    protected $fillable = [
        'title',
        'body',
        'c_name',
        'c_web',
        'cover_image',
        'user_id'
    ];

    // we can do the inverse by using garded which tells which fields are not okay to reassige
    // protected $guarded = [];
}
