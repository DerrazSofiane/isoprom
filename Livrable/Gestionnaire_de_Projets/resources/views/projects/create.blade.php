@extends('layouts.structure')

@section('csss')
	@parent
	<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('fonts/fontawesome/css/all.css') }}" rel="stylesheet">
@endsection

@section('content')


 <div class="page-header">
		<div class="form-group align-center">
			     	<h2 style="color :green" >Nouveau Projet </h2>
	  </div>
</div>
<br><br>
<form role="form" method="post" action="{{action('ProjectController@store')}}">
<input type="hidden" name="_token" value="{!! csrf_token() !!}">

	<div class="form-group">
		<label for="title" class="col-form-label">Sujet :</label>
		<input  type="text" class="form-control" name="title" required>
	</div>

	<div class="form-row">
		<div class="form-group col">
			<label class="col-form-label col-md-2 col-sm-12">État :</label>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="state_RadioBtn" id="EnCours_RadioBtn" value="1" checked >
				<label class="form-check-label" for="EnCours_RadioBtn">En-cours</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="state_RadioBtn" id="Clos_RadioBtn" value="0">
				<label class="form-check-label" for="Clos_RadioBtn">Clos</label>
			</div>
		</div>

		<div class="form-group col">
			<label for="limitDate" class="col-form-label">Date Limite :</label>
			<div class="input-group date form_datetime col-md-5"
				data-date="16-09-1979T05:25:07Z" data-date-format="dd-mm-yyyy hh:ii:ss"
				data-link-field="dtp_input1"
				style="min-width: 300px;">

				<input id="limitDate" name="limitDate" class="form-control" size="16" type="text" value="09-09-2019 11:36:04" readonly>
				<span class="input-group-append">
					<span class="input-group-text fa fa-times fa-lg"></span>
				</span>
				<span class="input-group-append">
					<span class="input-group-text fa fa-calendar-alt fa-lg"></span>
				</span>
			</div>
			<input type="hidden" id="dtp_input1" value=""/><br/>
		</div>

	</div>
	<div class="form-group col-lg-12">
		<div class="form-check">
			<input class="form-check-input" type="checkbox" id="displacement" name="displacement" checked>
			<label class="form-check-label" for="displacement">
				Déplacement
			</label>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col">
			<label class="col-form-label">Client :</label>
			<select name = "client_id[]" id="client_id" class="form-control">
				@foreach ($clients as $client)
					<option value="{{ $client['id'] }}">{{ $client['name'] }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col">
			<label class="col-form-label">Chef de Projet :</label>
			<select name = "user_id[]" id="user_id" class="form-control">
				@foreach ($project_managers as $project_manager)
					<option value="{{ $project_manager['id'] }}">{{ $project_manager['name'] }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="description" class="col-form-label">Description :</label>
		<textarea class="form-control" rows="6" name="description" id="description" required></textarea>
	</div>

	<div class="form-group">
		<label class="col-form-label">Commentaire :</label>
		<textarea class="form-control" rows="6" name="comment" id="comment" required></textarea>
	</div>

<input type="submit" class="btn btn-success btn-h1-spacing float-right" value="Ajouter">
</form>

@endsection


@section('jss')
	@parent
	<script src="{{ asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker.fr.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker-setup.js') }}"  type="text/javascript"></script>
@endsection
