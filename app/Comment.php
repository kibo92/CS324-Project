<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text','created_at','blog_id','user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
	];
	/**
	* Getter for User from Question (with)
	*/
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
}