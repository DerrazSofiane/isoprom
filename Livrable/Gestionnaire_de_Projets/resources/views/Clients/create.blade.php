@extends('layouts.structure')

@section('content')

<style> h2{ color: green; } </style>
 <div class="page-header">
		<div class="form-group align-center">
			     	 <h2>Nouveau Client </h2>  </div>
</div>
<br>
<form role="form" method="post" action="{{action('ClientController@store')}}">
<input type="hidden" name="_token" value="{!! csrf_token() !!}">

	<div class="form-group">
		<label for="title" class="col-form-label">Numéro d'enregistrement :</label>
		<input type="text" class="form-control" name="registrationNumber" required >
	</div>

 <div class="form-row">
  	<div class="form-group col-6">
  		<label for="title" class="col-form-label">Nom :</label>
  		<input type="text" class="form-control" name="name" required>
  	</div>

  	<div class="col">
      <div class="form-group">
          <label for="title" class="col-form-label">Email :</label>
          <input type="text" class="form-control" name="email" placeholder="email@exemple.com" required>
      </div>
    </div>
</div>

 <div class="form-row">
  	<div class="form-group col-6">
  		<label for="title" class="col-form-label">Adresse :</label>
  		<input type="text" class="form-control" name="address" required>
  	</div>

  	<div class="col">
      <div class="form-group">
          <label for="title" class="col-form-label">Numéro de téléphone :</label>
          <input type="text" class="form-control" name="phoneNumber" required>
      </div>
    </div>
</div>
	<div class="form-group">
		<label class="col-form-label">Commentaire :</label>
		<textarea type="text" class="form-control" name="comment" value="comment" required></textarea>
	</div>


<input type="submit" class="btn btn-success btn-h1-spacing fas fa-plus float-lg-right" value="Ajouter">
</form>

@endsection
