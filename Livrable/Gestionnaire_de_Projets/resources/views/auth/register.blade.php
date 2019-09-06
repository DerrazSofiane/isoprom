@extends('layouts.structure')

@section('content')
<div class="container">

  <div class="page-header">
    <br>
          <h2 style="color :gray" class="ml-5">Nouvel utilisateur</h2>
  </div><hr>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('Users.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">Rôle</label>
                        <div class="col-md-8">
                            <select class="field form-control" name="role">
                              <option value="ADMIN">Admin</option>
                              <option value="MANAGER">Gérant</option>
                              <option value="PROJECT_MANAGER">Chef de Projets</option>
                              <option value="EMPLOYEE">Employé</option>
                            </select>
                        </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nom</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Adresse email</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Mot de passe</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmer le mot de passe</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="comment" class="col-md-4 control-label">Commentaire</label>

                            <div class="col-md-8">
                                <textarea id="comment" type="text" row="6" class="form-control" name="comment" value="{{ old('comment') }}" required autofocus></textarea>

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-md-6">
                              <input type="submit" class="btn btn-success btn-h1-spacing fas fa-plus float-lg-right" value="Ajouter">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
