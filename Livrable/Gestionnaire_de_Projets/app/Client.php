<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $fillable =
	[ 'registrationNumber','name','email','address','phoneNumber','comment' ];

	public function projects(){
		return $this->hasMany('App\Project');
	}
}
