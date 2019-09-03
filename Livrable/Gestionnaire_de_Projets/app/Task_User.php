<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task_User extends Model
{
    protected $fillable = [ 'user_id','task_id','startDate','finishDate' ];

	public $table = "task_user";

	public static function Contains($idu,$idt){
		return Task_User::where('task_id','=',$idt)->where('user_id','=',$idu)->count();
	}
	// public static function makeUnique(){
	// 	$ch="";
	// 	$ishere=0;
	// 	while (!$ishere) {
	// 		$u = random_int(1, User::count());
	// 		$t = random_int(1, Task::count());
	// 		foreach (Task_User::all() as $tu) {
	// 			if($tu->user_id==$u && $tu->task_id==$t)
	// 			{
	// 				$ishere=1;break;
	// 			}
	// 		}
	// 		if(!$ishere)$ch=$ch." \n".$u." ".$t;
	// 	}
	// 	return $ch;
	// }
}
