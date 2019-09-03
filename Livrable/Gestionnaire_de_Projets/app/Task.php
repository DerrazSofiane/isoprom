<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = [
       'title','limitDate','state',
       'progress','priority','comment','project_id'
         ];
    //
    /*
    * L'utilisateur qui est concerné par de nombreuses taches
   */
    public function users(){
        // return $this->belongsToMany('App\User','tache_user','tache_id','user_id')->withPivot('date_debut', 'date_fin');
     return $this->belongsToMany('App\User')->withPivot('startDate', 'finishDate');
    }

	public function projects(){
		return $this->belongsTo('App\Project');
	}
}
