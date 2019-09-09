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
          <h2 style="color :gray" class="ml-5">Mon Profil</h2>
          <h6 style="color :seagreen" class="ml-5 pl-5">{{$user->hoursCount}}</h6>
  </div><hr>

	<div class="row">
      <!-- colonne de gauche -->
      <div class="col-md-3">
        <div class="text-center">
          <img id="mypic" src="{{URL('/')}}/storage/avatars/{{ ($user->avatar)?$user->avatar:'default.png' }}"
            style="border-radius:50%;height:50% ;width:50%" class="img-circle" alt="avatar">
          <input id="saveProfile" class="btn btn-success" type="submit" value="Enregistrer" hidden onclick="$('#form').submit();">

          <h6>{{$user->name}}</h6>
           <form action="{{ route('User.updateAvatar',$user->id) }}" method="post" enctype="multipart/form-data" id="form">
             <input  type="file" name="avatar" id="avatar"
              onchange="
              var reader = new FileReader();
              reader.onload = function (e) {
                 $('#mypic').attr('src', e.target.result);
              }
             reader.readAsDataURL(document.getElementById('avatar').files[0]);
              // console.log($(this));
              // $('#mypic').attr('src','{{URL::to('/')}}/storage/avatars/default.png');

              $('#saveProfile').attr('hidden',false);
              " hidden>

             <input  type="button" id="new_avatar"  class="btn btn-primary" value="Changer d'Avatar" onclick="$('#avatar').click();">
             <input  hidden value="{{ csrf_token() }}" name="_token">
           </form>
        </div>
      </div>

        <!-- edit form column -->
    <div class="col-md-9">

              <h3>Informations personnelles</h3><br>

              <form class="form-horizontal" role="form">
                <div class="form-group form-inline">
                  <label class="col-lg-3 control-label">Nom:</label>
                  <div class="col-lg-8" >
                    <input type="text" class="form-control sm-2" name="name" value="{{$user->name}}" disabled>
                  </div>
                </div>

                <div class="form-group form-inline">
                  <label class="col-lg-3 control-label">Role:</label>
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
