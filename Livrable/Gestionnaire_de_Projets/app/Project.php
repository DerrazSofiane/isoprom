<?php

namespace App;
use Carbon\Carbon;
use App\Task;
use App\Task_User;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable = [
			 'title','description','limitDate','startDate','finishDate','displacement',
			 'state','comment','user_id','client_id'
				 ];
		public $timestamps = true;

	public function tasks(){
		return $this->hasMany('App\Task');
	}

	public function clients(){
		return $this->belongsTo('App\Client');
	}
	/*
	* Une fois le projet cloturé, une date de fin doit être définie
	*/
	public function projetClos()
	{
		if($this->state == 0 && $this->finishDate == null){/*si le projet est clos*/
			return true;
			 /*  $project->finishDate=date('d-m-Y H:i:s');on precise la date de fin*/
		}else{
			return false;
			// $project->finishDate='0000-00-00 00:00:00';
		}
	}

	public static function getCounts($v){//$v est le diff par minutes
		$temp = $v/60/24;
		$vv = " ".floor($temp).'day(s)';
		$temp = ($temp -floor($temp)) *24;
		$vv = $vv." ".floor($temp).'hour(s)';
		$temp = ($temp -floor($temp)) *60;
		$vv = $vv." ".$temp.'min(s)';
		return $vv;
	}

	public static function useData_toCalculateHoursCount($t_us){
		$i=0;
		$t = [];
		$resM = 0;
		foreach ($t_us as $t_u) {
			$from = Carbon::parse($t_u->startDate);
			$to = Carbon::parse($t_u->finishDate);

			$currentCount = 0;

			if($t_u->needCalculating){
				$currentCount = $to->diffInMinutes($from) + $t_u->hoursCount*60;
			}else{
				$currentCount = $t_u->hoursCount*60;
			}

			$resM += $currentCount;
			$t[$i] = '('.$t_u->task_id.') '.$t_u->startDate.'. '.
				($t_u->finishDate?$t_u->finishDate
					.' '.Project::getCounts($to->diffInMinutes($from))
					.' '.Project::getCounts($currentCount)
					:'null').' :'.$t_u->hoursCount.':';

			$i++;
		}

		$fullRes = ' '.Project::getCounts($resM);

		return ($resM/60).'hour(s) = '.$resM.'minute(s) = '.$fullRes;
		// $dt = Carbon::parse('2012-10-5 23:26:11.123789');//$dt->day == Carbon::now()->day
	}
}
