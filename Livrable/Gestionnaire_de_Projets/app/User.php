<?php

namespace App;
use App\Task;
use App\Projet;
use App\Task_User;

use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','avatar','password','role','comment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     *
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}    
    * Les t�ches qui appartiennent � l'utilisateur
     */
    public function tasks(){
         //return $this->belongsToMany('App\Tache','tache_user','user_id','tache_id')->withPivot('date_debut', 'date_fin');
     return $this->belongsToMany('App\Task')->withPivot('startDate','finishDate');
    }
    public function projects(){

     return $this->belongsToMany('App\Project');
    }
    /*
    *v�rifier le r�le de l'utilisateur authentifi�
    */
    public function Auth_hasRole($role){
      $user=User::find(auth()->id());/*l'utilisateur authentifi�*/

      if($user->role==$role){
        return true;
      }
        return false;
    }
    /*
    *obtenir le r�le de l'utilisateur authentifi�
    */
    public static function hasRole($role){

      return User::where('role','Like',$role)->get();
    }

    /*
    * chaque utilisateur a plusieurs timers li�es � de nombreuses t�ches
    */
    public function timers() {
     return $this->hasMany('App\Timer');
    }

    public static function getEmployeHoursCount($id){
        $t_us = Task_User::where('user_id',$id)->get();

        // dd(Project::useData_toCalculateHoursCount($t_us));
        return Project::useData_toCalculateHoursCount($t_us);
    }

}
