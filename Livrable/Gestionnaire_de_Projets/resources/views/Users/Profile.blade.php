@extends('layouts.structure')

@section('jss')
@parent
 <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
 <script>

 $(document).ready(function(){
   function selectedValue(){
     //var val =document.getElementById('role').value;
     alert($('#role'));
   }
 });
 </script>
@endsection
@section('content')

<div class="container">

  <div class="page-header">
    <br>
          <h2 style="color :gray" class="ml-5">Profil de : {{$user->name}}</h2>
  </div><hr>

	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="{{URL::to('/')}}/storage/avatars/{{ $user->avatar }}" style="border-radius:50%;height:50% ;width:50%" class="img-circle" alt="avatar">
          <h6>{{$user->name}}</h6>

        </div>
      </div>

        <!-- modifier la colonne du formulaire -->
    <div class="col-md-9">

              <h3>Informations personnelles</h3><br>
              <form action="{{ route('Users.edit',$user->id) }}" method="get">
              	<button type="submit" class="btn btn-primary float-right"><i class="fa fa-edit"></i> Modifier</button>
              </form>
              <br><hr><br>

              <form class="form-horizontal" role="form">
                <div class="form-group form-inline">
                  <label class="col-lg-3 control-label">Nom:</label>
                  <div class="col-lg-8" >
                    <input type="text" class="form-control sm-2" name="name" value="{{$user->name}}" disabled>
                  </div>
                </div>

                <div class="form-group form-inline">
                  <label class="col-lg-3 control-label">Rôle:</label>
                  <div class="col-lg-8" >
                  <input type="text" class="form-control sm-2" value="{{$user->role}}" disabled>
                  </div>
                </div>


                <div class="form-group form-inline">
                  <label class="col-lg-3 control-label">Email:</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control sm-2" name="email"  value="{{$user->email}}" disabled>
                  </div>
                </div>

            </form>
      </div>
    </div>
  </div>
      <hr>


@endsection
