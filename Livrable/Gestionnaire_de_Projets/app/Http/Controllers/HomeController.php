<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//
use Auth;// pour obtenir la liste des notifications des utilisateurs actuellement connectés.
use App\User;
//
use App\Project;
use App\Task;
use App\Client;
//
use Yajra\Datatables\Datatables;// datatables.

class HomeController extends Controller
{
/////////////////////////// Inscription de l'administrateur ///////////////////////////
	//
	//  vérifier si la base de données des utilisateurs est vide.
	//
	public function CheckFirstRegistration(){
		return (User::where('role','like','ADMIN')->count() == 0);//true -> empty ;; false -> full
	}
	//
	// renvoie la première page d'inscription de l'administrateur.
	//
	public function adminRegisterIndex(){
		if((Auth::guest() && $this->CheckFirstRegistration()) || (!Auth::guest() && auth::user()->role == 'ADMIN'))
			return view('AdminRegistration');
		else return redirect()->route('home.index');
	}
	//
	// créer le premier compte utilisateur admin.
	//
	public function firstAdminStore(Request $request){
		$this->validate($request, [
			'name' => 'required|min:3|max:50',
			'email' => 'email',
			'comment' => 'required',
			'password' => 'required|confirmed|min:6',
		]);
		//if ($validator->fails()) Les données fournies n'ont pas passé la validation
		$u = new User([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'role' => 'ADMIN',
			'comment' => $request->comment,
		]);

		$u->save();

		return  redirect()->route('login');
	}
/////////////////////////////  ///////////////////  //////////////////////////

//////////////////////////////// Home page ////////////////////////////////////
	//
	// renvoie l'index de la page d'accueil.
	//
	public function index(){
		if(!Auth::guest()){
			$ps=Project::orderBy('updated_at', 'ASC')
				->where('state','=',1)
				->take(3)
				->get(['id', 'title', 'state', 'updated_at']);

			$ts=Task::orderByRaw('priority - updated_at', 'ASC')
				->where('state','like','IN_PROGRESS')
				->take(3)
				->get(['id', 'title', 'state', 'priority', 'updated_at']);

			return view('index')->with('LastFewProjects',$ps)
				->with('LastFewTasks',$ts);
		}else if($this->CheckFirstRegistration())
				return redirect()->route('admin.register.index');
			else return  redirect()->route('login');
	}
/////////////////////////////  ///////////////////  //////////////////////////

/////////////////////////////// Notification ///////////////////////////////////
	//
	// définir une notification read_at à la date du jour.
	//
	public function notifSeen($notifId){
		$user = Auth::user();
		$notif =  $user->Notifications
			->where('id','=',$notifId)[0];

		$objectId = $notif['data']['id'];
		$istype =  $notif['data']['type'];

		$notif->markAsRead();

		if($istype == 'App\Task'){
			return redirect()->route('Tasks.show', $objectId);
		}
		else if($istype == 'App\Project'){
			return redirect()->route('Projects.show', $objectId);
		}
		else{
			flash('Objet non Trouvé !')->error();
			return back();
		}
	}
/////////////////////////////  ///////////////////  //////////////////////////

//////////////////////////////// DataTables ////////////////////////////////////
	//
	// renvoie toutes les colonnes possibles.
	//
	public static function All_Cols(){
		return [    'Projects'  =>['id', 'title', 'description'],
			'Tasks'     =>['id', 'title', 'state'],
			'Clients'   =>['id', 'name', 'email'],
			'Users'     =>['id', 'name', 'email']
		];
	}
	//
	// DataTables index.
	//
	public function index2($name){
		return view('welcome')
			->withCurrent($name)
			->withCols(array_slice(HomeController::All_Cols()[$name], 1));
	}
	//
	// obtenir des données de la base de données à afficher sur la dataTable.
	//
	public function getData($name){
		$GLOBALS['cName'] = $name;
		$vals=HomeController::All_Cols()[$name];
		switch($name)
		{
			case 'Projects' :
				$obj = Project::select($vals);
				break;
			case 'Tasks' :
				$obj = Task::select($vals);
				break;
			case 'Clients' :
				$obj = Client::select($vals);
				break;
			case 'Users' :
				$obj = User::select($vals);
				break;

			default :
				flash('Nothing Happened !')->warning();
				return back();
		}
		return Datatables::of($obj)->make(true);
	}
	//
	// supprimer un objet de la base de données.
	//
	public function removedata(Request $request, $name){
		switch($name)
		{
			case 'Projects' :
				$obj = Project::find($request->input('id'));
				break;
			case 'Tasks' :
				$obj = Task::find($request->input('id'));
				break;
			case 'Clients' :
				$obj = Client::find($request->input('id'));
				break;
			case 'Users' :
				$obj = User::find($request->input('id'));
				break;

			default :
				return back()->with('message', 'nothing happened!');
		}

		if($obj->delete())
		{
			return back()->with('message', 'Data Deleted '.$request->input('id'));
		}
		return back()->with('message', 'nothing happened!!');
	}
	//
	// supprimer plusieurs objets de la base de données.
	//
	public function massremove(Request $request, $name){
		switch($name)
		{
			case 'Projects' :
				$obj = Project::whereIn('id', $request->input('id'));
				break;
			case 'Tasks' :
				$obj = Task::whereIn('id', $request->input('id'));
				break;
			case 'Clients' :
				$obj = Client::whereIn('id', $request->input('id'));
				break;
			case 'Users' :
				$obj = User::whereIn('id', $request->input('id'));
				break;

			default :
				return back()->with('message', 'nothing happened!');
		}
		if($obj->delete())
		{
			flash('Data Deleted Successfully !')->success();
			return back();
		}

		flash('Nothing happened !')->success();
		return back();
	}
/////////////////////////////  ///////////////////  //////////////////////////
}
