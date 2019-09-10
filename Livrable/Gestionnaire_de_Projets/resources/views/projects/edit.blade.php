@extends('layouts.structure')
@section('csss')
	@parent
	<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('fonts/fontawesome/css/all.css') }}" rel="stylesheet">
@endsection

@section('content')

	<div class="page-header">
		<div class="form-group form-inline align-center">
			<h2 style="color :green" > Modifier le Projet : </h2>
			<h3 style="color :gray" class="ml-5">{{ $p->title }}</h3>
		</div>
	</div>
	<hr>

<form action="{{ route('Projects.update', $p) }}" method="POST" class="form-horizontal">
<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<label for="title" class="col-form-label" >Sujet :</label>
		<input type="text" class="form-control " name="title" value="{{$p->title}}">
	</div>
	<div class="form-row">
		<div class="form-group col">
			<label class="col-form-label mt-0">Client :</label>
			<div class="form-control" name="client_id"> {{$p->client_name}}</div>
		</div>
		<div class="form-group col">
			<label class="form-label mt-1" >Chef de Projet :</label>
			<select name = "user_id[]" id="user_id" class="form-control">
				@foreach ($project_managers as $project_manager)
					<option value="{{ $project_manager['id'] }}">{{ $project_manager['name'] }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col">
			<label for="limitDate" class="col-form-label">Date Limite :</label>
			<div class="input-group date form_datetime"
                data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm-dd hh:ii:ss"
				data-link-field="dtp_input1"
				style="min-width: 350px;">
				<input id="limitDate" name="limitDate" class="form-control" size="16" type="text" value="{{ $p->limitDate }}" readonly>
				<span class="input-group-append">
					<span class="input-group-text fa fa-times fa-lg"></span>
				</span>
				<span class="input-group-append">
					<span class="input-group-text fa fa-calendar-alt fa-lg"></span>
				</span>
			</div>
			<input type="hidden" id="dtp_input1" value=""/><br/>
		</div>
		<div class="col form-row">
			<!--état-->
			<div class="form-group col ml-5">
				<label class="col-form-label ">Etat :</label><br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="state_RadioBtn"
						id="EnCours_RadioBtn" value="1" <?php echo ($p->state)?'checked':''?>
						{{(Auth::user()->Auth_hasRole('ADMIN')||Auth::user()->Auth_hasRole('MANAGER'))?'':'disabled'}}
						>
					<label  class="form-check-label" for="EnCours_RadioBtn">en-cours</label>

					<input class="form-check-input ml-3" type="radio" name="state_RadioBtn"
						id="Clos_RadioBtn" value="0" <?php echo (!$p->state)?'checked':'' ?>
						{{(Auth::user()->Auth_hasRole('ADMIN')||Auth::user()->Auth_hasRole('MANAGER'))?'':'disabled'}}>
					<label class="form-check-label" for="Clos_RadioBtn">clos</label>
				</div>
			</div>
			<!--déplacement-->
			<div class="form-group col mt-4">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="displacement"
						id="displacement" <?php echo ($p->displacement)?'checked':'' ?> >
					<label class="form-check-label" for="displacement">
						Déplacement
					</label>
				</div>
			</div>
		</div>
	</div>

    <div class="form-group">
         <label for="description" class="col-form-label" >Description :</label>
         <textarea class="form-control" rows="4" name="description" value="description">{{$p->description}}</textarea>
    </div>

  <div class="form-groupe">
    <label class="col-form-label" >Commentaire :</label></strong>
    <textarea class="form-control" rows="4" name="comment" value="" >{{$p->comment}}</textarea>
  </div>
<br>
 <button type="submit" name="submit" class="btn btn-primary float-right"> <i class="fas fa-save"> Enregistrer</i></button>

    </form>
<hr>
<br>


@endsection

@section('jss')
	@parent
   <script src="{{ asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker.fr.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker-setup.js') }}"  type="text/javascript"></script>
     @endsection
