<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;//added
use App\Http\Controllers\Controller;
use Session;
use Auth;
use App\User;
use App\Task;
use App\Task_User;
class UserController extends Controller
{

	public function __construct(){
   /*permettre à l'invité de changer son mot de passe */
	 /*autoriser tous les utilisateurs à mettre à jour leur avatar de profil uniquement*/
	 /*seul l'administrateur a accès à la base de données de tous les utilisateurs*/
	 /*seuls le gérant et l'admin peuvent ajouter des utilisateurs .. (Admin ajoute Gérant) */
  	// $this->middleware('admin',['except' => ['show','update_avatar','update','editPassword','updatePassword']]);
      $this->middleware('auth');
	}

	//
	// returns register
	//
	public function registerIndex(){
		return view('auth.register');
	}
	//
	public function update_avatar(Request $request,$id){

		$this->validate($request, [
		 'avatar'  => 'required|mimes:jpg,jpeg,png'
     ]);
			$image =$request->file('avatar');
			$new_image = rand() . '.' . $image->getClientOriginalExtension();
      		$image->move(public_path('storage/avatars'), $new_image);/*put image in storage folder*/

			$user=User::find($id);
			$user->avatar=$new_image;
			$user->save();

		 return back()->with('success', 'Image Uploaded Successfully')->with('user', $user);

		/*
		 $this->validate($request, [
		  'avatar'  => 'required|image|mimes:jpg,png,gif|max:2048'
		]);*/
   }

	/**
		* Display a listing of the resource.
		*
		* @return \Illuminate\Http\Response
		*/
	public function index()
	{
		$this->authorize('index', User::class);
		$us = User::all();
		$u = Auth::user();

		return view('Users.index')->withUsers($us)->withUser($u);
	}

	/**
		* Show the form for creating a new resource.
		*
		* @return \Illuminate\Http\Response
		*/
	public function create()
	{
		 $this->authorize('create', User::class);
		return view('auth.register');
	}
/*storeAdmin(){
	admin role
}*/
	/**
		* Stocker une ressource nouvellement créée dans le stockage.
		*
		* @param  \Illuminate\Http\Request  $request
		* @return \Illuminate\Http\Response
		*/
	public function store(Request $request)
	{
		$u = new User([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'role' => $request->role,
			'comment' => $request->comment,
		]);
		// dd($request->all(),$u);
		$u->save();

		flash('Utilisateur ajouté avec succé !')->success();
		return redirect()->route('Users.index');
	}

	/**
		* Affiche la ressource spécifiée.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function show($id) /*auth profile*/
	{
		$u = User::find($id);

		if($u->role == 'EMPLOYEE')
			$u->hoursCount = User::getEmployeHoursCount($id);

		return view('Users.show')->withUser($u);
	}

	public function showProfile($id) /*users profile*/
	{

		$u = User::find($id);
		$this->authorize('showProfile',$u);

		if($u->role == 'EMPLOYEE')
			$u->hoursCount = User::getEmployeHoursCount($id);



		return view('Users.Profile')->withUser($u);
	}

	/**
		* Afficher le formulaire pour modifier la ressource spécifiée.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function edit($id)
	{

		$u = User::find($id);
		 $this->authorize('edit',$u);

			return view('Users.edit')->withUser($u);
	}
	/*
	 *  formulaire pour modifier le mot de passe
	*/
	public function editPassword()
	{

			return view('Mail.edit_Password');
	}
	/*
	* modifierpassword
	*/
	public function updatePassword(Request $request)
	{

			$u = User::where('email','=',$request->email)->first();
		$u->password = bcrypt($request->password);

		$u->save();

    flash('Mot de passe a été modifié. Veuillez vous connecter !')->success();
	  return	redirect()->route('login');
	}
	/**
		* Met à jour la ressource spécifiée dans le stockage.
		*
		* @param  \Illuminate\Http\Request  $request
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function update(Request $request, $id)
	{

			$u = User::find($id);


		$u->name = $request->name;
		$u->email = $request->email;
		$u->role = $request->role;/*attribuer un nouveau role*/
	//	$u->password = $request->password;

		$u->comment = $request->comment;

		$u->save();
    flash('Utilisateur enregistré avec succès !')->success();
		return redirect()->route('User.Profile',$u->id)->withUser($u);
	}

	/**
		*Supprime la ressource spécifiée du stockage.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function destroy($id)
	{

		$u = User::find($id);
		 $this->authorize('delete',$u);

    if($u->role=='EMPLOYEE'){/*détache les tâches de cet utilisateur*/
			$tasks_id=Task_User::where('user_id',$u->id)->get(['task_id']);
			$tasks=Task::whereIn('id',$tasks_id)->get();
			foreach($tasks as $task){

			}
		}
		$u->delete();

		flash('Utilisateur supprimé avec succès !')->warning();
		return redirect()->route('Users.index');
	}
}
