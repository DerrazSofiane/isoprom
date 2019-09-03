<?php
namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;
use App\User;
use App\Task;
use App\Project;
use App\Task_User;

use Session;
use Auth;

use Carbon\Carbon;

use Illuminate\Http\Request;
class TaskController extends Controller
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
        $ts = Task::all();
        foreach ($ts as $t) {
            //récupère le nom du projet auquel appartient la tâche en cours.
            $t->project_title=Project::find($t->project_id)->title;
            //obtenir l'état du projet
            $t->project_state=Project::find($t->project_id)->state;
            //obtenir le plus petit 'date_debut' que tous les utilisateurs ont sur la tâche en cours
            $t->d_d=Task_User::where('task_id',$t->id)
                ->min('startDate');
        }
        // dd($ts);
        return view('tasks.index' ,compact('ts'));
    }

        /**
         * Afficher une liste des tâches de l'employé ($id).
         *
         * @return \Illuminate\Http\Response
         */
        public function MyTasks($id)
        {

          $id_ts=Task_User::where('user_id','=',$id)->get(['task_id']);/*obtenir le tasks_id lié à user_id*/

              //foreach ($id_ts as $id_t) {/*for each task|user get :  */

              $ts=Task::whereIn('id', $id_ts)->get(); /*les infos de chaque tâche de la table des tâches*/

                  foreach ($ts as $t) {
                      //récupère le nom du projet auquel appartient la tâche en cours.
                      $t->project_title=Project::find($t->project_id)->title;
                      /*startDate & FinishDate ; dev en cours*/
                      $s_d=Task_User::where('user_id','=',$id)->where('task_id','=',$t->id)->get(['startDate']); /*start_date */
                      $f_d=Task_User::where('user_id','=',$id)->where('task_id','=',$t->id)->get(['finishDate']); /*end_date*/
                  }
              //}
            return view('tasks.mesTaches' ,compact('ts'));
        }
    /**
     * Montrer le formulaire pour créer une nouvelle ressource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      /*--obtenir tous les employés libre--*/
      $employees=User::where('role','Like','EMPLOYEE')->get();
      $projects=Project::all();
      return view('tasks.create',compact('employees','projects'));
    }
    /**
     * Stocker une ressource nouvellement créée dans le stockage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $newTask = new Task([
            'title' => $request->title,
            'limitDate' => $request->limitDate,
            'state' =>'IN_PROGRESS',
            'progress' => 0,
            'priority' => ($request->priority_RadioBtn),
            'comment' => $request->comment,
            // 'user_id' =>$request->user_id[0],/*non stocké! l'utilisateur doit être associé à cette tâche*/
            'project_id'=>$request->project_id[0],
          ]);
      $newTask->save();// Eric <3

      $newTaskUser = new Task_User([
            'task_id' => $newTask->id,
            'user_id' => $request->user_id[0],
            'startDate' => $newTask->created_at,
            'finishDate' => null,
            'hoursCount' => 0,
            'needCalculating' => 0,
          ]);
      $newTaskUser->save();

      $newTask->title = 'task "' .$newTask->title.'" created';
      \Notification::send(User::find($request->user_id[0]), new \App\Notifications\UserNotification($newTask));

      flash('Tache créer avec succé !')->success();
      return redirect()->route('Tasks.show',$newTask->id)->withTask($newTask);
    }
    /**
     *voir une tâche choisie
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $t=Task::find($id);/*get task*/
      $p=Project::find($t->project_id);/*obtenir le projet lié à cette tâche*/
      $id_us=Task_User::where('task_id','=',$t->id)->get(['user_id']);/*obtenir l'employé lié à cette tâche*/
      $us=User::whereIn('id', $id_us)->get(['id','name','email','comment']);/*obtenir des informations sur l'employé de la table des utilisateurs*/
        return view('tasks.show')->withTask($t)->withProject($p)->withUsers($us);
    }
    /*
    * vérifier si un utilisateur existe déjà dans un tableau d'utilisateurs actuels
    * afin d'afficher uniquement les autres utilisateurs non liés à une tâche x
    */
    public function IDexist($id,$id_us){
      if(!in_array("id",$id_us)){/*utilisateur non actif*/
        return true;
      }else {
        return false;
      }
    }
    /**
     * Afficher le formulaire pour modifier la ressource spécifiée.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

      $task = Task::find($id);
      $task->project_title = Project::find($task->project_id)->title;
      //Affiche tous les projets sur l'entrée de sélection de projet
      $projects = Project::all();
      //Obtenir les employés actuels pour la tâche en cours
      //et d'autres employés (ne travaillant pas sur cette tâche),
      //Puis ajouter pour chaque employé son nombre de tâches
      $us_id = Task_User::where('task_id', '=', $task->id)->get(['user_id']);
        $currentEmployees = User::whereIn('id', $us_id)->get(['id', 'name']);
        $otherEmployees = User::whereNotIn('id', $us_id)
          ->where('role', 'like', 'EMPLOYEE')->get(['id', 'name']);
        foreach ($currentEmployees as $u) {
          $u->taskCount = Task_User::where('user_id',$u->id)->count();
        }
        foreach ($otherEmployees as $u) {
          $u->taskCount = Task_User::where('user_id',$u->id)->count();
        }
      return view('tasks.edit',compact('task', 'projects', 'currentEmployees', 'otherEmployees'));
    }
    /*
    *  État d'avancement / mise à jour des employés
    * et mettre à jour le commentaire si édité ..
    */
    public function updateProgress(Request $request, $id)
    {
      // dd(auth::user()->id);
          $task =Task::find($id);
          $t_u = Task_User::where('user_id','=',auth::user()->id)
                ->where('task_id','=',$task->id)->get();

          $task->comment=$request->comment;
          $task->progress=$request->progress;

          if($request->progress=="100" && $task->state=='IN_PROGRESS'){
            $task->state='FINISHED';

            $t_u->finishDate = date('Y-m-d H:i:s');
            $t_u->needCalculating = 1;
          }else{
            $task->state='IN_PROGRESS';

            $from = Carbon::parse($t_u->startDate);
            $to = Carbon::parse($t_u->finishDate);
            $t_u->hoursCount = $to->diffInMinutes($from);

            $t_u->startDate = date('Y-m-d H:i:s');
            $t_u->finishDate = null;
            $t_u->needCalculating = 0;
          }

          $task->save();
          $t_u->save();
          // if($t_u->needCalculating)//close task
          // dd();


          $task->title = 'task "' .$task->title.'" and it relations updated';
          \Notification::send(User::whereIn(Task_User::where('task_id','=',$task->id)
              ->get('user_id'))->get('id'),
              new \App\Notifications\UserNotification($task));

          flash('Tache Enregistré avec succé !')->success();
          return redirect()->route('Tasks.show',$task->id)->withTask($task);
    }

    /**
     * Tâche de mise à jour (changement des travailleurs actuels)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $task=Task::find($id);

      $add = explode(",", $request->addTable);
      $rm = explode(",", $request->removeTable);
      // $aaa=Task_User::where('task_id', '=', $id)->get(['user_id']);
      if(count($add)>0 && $add[0]!="")
        foreach ($add as $u_id) {
          if(!Task_User::Contains($u_id, $id)){
            $employee=User::where('id', $u_id)->first();
            $employee->tasks()->attach($task);
          }
        }
      if(count($rm)>0 && $rm[0]!="")
        foreach ($rm as $u_id) {
          if(Task_User::Contains($u_id, $id)){
            $employee=User::where('id', $u_id)->first();
            $employee->tasks()->detach($task);
          }
        }
      //dd($add, $rm, $aaa, Task_User::where('task_id', '=', $id)->get(['user_id']));

      $task->title =$request->title;
      $task->limitDate =$request->limitDate;
      $task->priority =($request->priority_RadioBtn);
      $task->comment =$request->comment;

      if ($request->has('validation')) {
        $task->state = 'VALIDATED';
        $task->progress = 100;
      }else  $task->state = 'IN_PROGRESS';

      $task->save();


      $task->title = 'task "' .$task->title.'" updated';
      \Notification::send(
          User::whereIn('id', Task_User::where('task_id','=',$task->id)->get(['user_id']))->get(['id']),
          new \App\Notifications\UserNotification($task));

      flash('Tache Enregistré avec succé!')->success();
       return redirect()->route('Tasks.show',$task->id)->withTask($task);
    }
    /*
    * ajouter un employé à une tâche spécifique
    */
    public function addEmployee($id,$empid){
      $task=Task::find($id);
      $employee=User::where('id', $empid)->first();/*obtenir des informations sur l'employé de la table des utilisateurs*/
      $employee->tasks()->attach($task);
    }
    /*
    * ajouter une tâche à un projet spécifique
    */
    public function addTaskToPrj($id){

     /*--obtenir tous les employés libre--*/
     $employees=User::where('role','Like','EMPLOYEE')->get();
     $project=Project::find($id);/*current project*/
     return view('tasks.create',compact('employees','project'));
    }
    /*
    * retirer un employé d'une tâche spécifique
    */
    public function removeEmployee($id,$empid){
      $task=Task::find($id);
      $employee=User::where('id', $empid)->first();/*l'employé que nous voulons détacher*/
      $employee->tasks()->detach($task);
    }
    /**
     * Supprime la ressource spécifiée du stockage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $t = Task::find($id);
        $t->delete();
        return redirect()->route('Tasks.index');
    }
}
