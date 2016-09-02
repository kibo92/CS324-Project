<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text','user_id','created_at','title'
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
	
	/**
	* Getter for all answers of question
	*/
	public function comments()
	{
		return $this->hasMany('App\Comment');
	}
}