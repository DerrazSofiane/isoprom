<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Client;

class ClientController extends Controller
{

	public function __construct(){

$this->middleware('admin',['except' => ['show']]);
}
	/**
		* Display a listing of the resource.
		*
		* @return \Illuminate\Http\Response
		*/
	public function index()
	{
		$cs = Client::all();

		return view('Clients.index')->withClients($cs);

	}

	/**
		* Show the form for creating a new resource.
		*
		* @return \Illuminate\Http\Response
		*/
	public function create()
	{
		return view('Clients.create');
	}

	/**
		* Store a newly created resource in storage.
		*
		* @param  \Illuminate\Http\Request  $request
		* @return \Illuminate\Http\Response
		*/
	public function store(Request $request)
	{
		$c = new Client([
			'registrationNumber' => $request->registrationNumber,
			'name' => $request->name,
			'email' => $request->email,
			'address' => $request->address,
			'phoneNumber' => $request->phoneNumber,
			'comment' => $request->comment,
		]);
		$c->save();

		flash('Client créer avec succès !')->success();
		return redirect()->route('Clients.show',$c->id)->withClient($c);
	}

	/**
		* Display the specified resource.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function show($id)
	{
		$c = Client::find($id);
		return view('Clients.show')->withClient($c);
	}

	/**
		* Show the form for editing the specified resource.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function edit($id)
	{
		$c = Client::find($id);
		return view('Clients.edit')->withClient($c);
	}

	/**
		* Update the specified resource in storage.
		*
		* @param  \Illuminate\Http\Request  $request
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function update(Request $request, $id)
	{
		$c = Client::find($id);

		$c->registrationNumber = $request->registrationNumber;
		$c->name = $request->name;
		$c->email = $request->email;
		$c->address = $request->address;
		$c->phoneNumber = $request->phoneNumber;
		$c->comment = $request->comment;

		$c->save();
		flash('Client enregistré avec succès !')->success();

		return redirect()->route('Clients.show',$id)->withClient($c);
	}

	/**
		* Remove the specified resource from storage.
		*
		* @param  int  $id
		* @return \Illuminate\Http\Response
		*/
	public function destroy($id)
	{
		$c = Client::find($id);

		$c->delete();

		flash('Client supprimé avec succès !')->warning();
		return route('Clients.index');
	}
}
