@extends('layouts.structure')


@section('content')

<style> h2{ color: green; }

</style>
<div class="page-header">
  <div style="border-bottom:1px dashed green" class="form-group form-inline align-center">
        <h2 style="color :green" >Client :</h2>
        <h3 style="color :gray" class="ml-5">{{ $client->name }}</h3>
  </div>
</div>
<br>
  <form action="{{ route('Clients.edit',$client->id) }}" method="get">
    <button type="submit" class="btn btn-primary" style="float: right;">
      <i class="fa fa-edit"></i> Modifier
    </button>
  </form>

	<div class="form-row">
    <div class="form-group mr-4 col-5">
      <strong><label class="col-form-label mr-3">Nom :</label>
       <div class="form-control" name="name">{{ $client->name }}</div>
    </div>
  	<div class="form-group col">
  		<label for="title" class="col-form-label mr-4 ">Numéro d'enregistrement :</label>
    	<div class=" col-8" name="registrationNumber">{{$client->registrationNumber}}</div>
  	</div>
  </div>

	<div class="form-row">
				 <div class="form-group mr-4 col-4">
						<label class="col-form-label mr-3">Email :</label>
						<div class="form-control" name="email">{{ $client->email }}</div>
				 </div>
					<div class="form-group col-6">
						<label class="col-form-label mr-4 ">Adresse :</label>
				  	<textarea type="text" class="form-control col-8" name="address" disabled>{{ $client->address }}</textarea>
					</div>
    </div>

  <div class="col">
  	<div class="form-group">
      <label class="col-form-label mr-3">Numero de Telephone :</label>
      <div class="form-control col-4" name="phoneNumber">{{ $client->phoneNumber }}</div>
  	</div>
  </div>

  	<div class="form-group ml-3">
  		<label class="col-form-label">Commentaire :</label>
  		<textarea type="text" class="form-control col-8" name="comment" disabled>{{$client->comment}}</textarea>
  	</div>

</div>
@endsection
