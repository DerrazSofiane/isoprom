<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Task;
use App\Project;
use App\User;
use App\Client;
use App\Task_User;

use Session;
use Auth;

class RapportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Affiche une liste de la ressource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ps = Project::all();
        return view('projects.index' ,compact('ps'));
    }

    public static function calculate_User_HoursCount($id){
        // $t_us = Task_User::whereIn('task_id',Task::where('project_id','Like',$id)->get(['id']))->get();

        // dd($t,Project::useData_toCalculateHoursCount($t_u));
        return Project::useData_toCalculateHoursCount($t_u);
    }

    /**
     * Affiche la ressource spécifiée.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $p = Project::find($id);

        // $this->authorize('show',$p);

        // $c=Client::find($p->client_id);

        // $u=User::find($p->user_id);

        // $tasks=Task::where('project_id','Like',$p->id)->get();/*get all tasks related */

        // foreach($tasks as $task){//get the users_id related to this task_id
        //     $task->worker = User::whereIn('id',
        //         Task_User::where('task_id','=',$task->id)->get(['user_id']))
        //         ->get(['id', 'name']);
        // }
        // $p->daysCount = ProjectController::calculateHoursCount($p->id);

        return view('projects.show');
    }

}
