@extends('layouts.structure')

@section('csss')
	@parent
	<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('fonts/fontawesome/css/all.css') }}" rel="stylesheet">
@endsection

@section('content')

<style> h2{ color: green; } </style>
<br><br>
 <div class="page-header">
		<div class="form-group align-center">
			     	 <h2>Nouvelle Tâche </h2>  </div>
</div>
<br><br>
<form role="form" method="post" action="{{action('TaskController@store')}}">
<input type="hidden" name="_token" value="{!! csrf_token() !!}">

	<div class="form-group">
		<label for="title" class="col-form-label">Sujet :</label>
		<input type="text" class="form-control" name="title" required>
	</div>

 <div class="form-row">
	{{-- <div class="col"> --}}
		<div class="form-group col-6">
			<label class="col-form-label">Projet attaché :</label>
			<select name = "project_id[]" id="project_id" class="form-control">
				<?php if(isset($project)):?>
				  <option value="{{ $project['id'] }}">{{ $project['title'] }}</option>
				<?php elseif(isset($projects)): ?>
					@foreach ($projects as $project)
						<option value="{{ $project['id'] }}">{{ $project['title'] }}</option>
					@endforeach
				<?php endif; ?>
			</select>
		</div>
	{{-- </div> --}}

	<div class="col">
		<div class="form-group">
			<label for="date_limite" class="col-md-3 col-form-label">Date Limite :</label>
			<div class="input-group date form_datetime col-md-5"
                data-date="16-09-1979T05:25:07Z" data-date-format="dd-mm-yyyy hh:ii:ss"
				data-link-field="dtp_input1"
				style="min-width: 100%">

				<input id="limitDate" name="limitDate" class="form-control" size="16" type="text"
					value="09-09-2019 11:36:04" readonly required>
				<span class="input-group-append">
					<span class="input-group-text fa fa-times fa-lg"></span>
				</span>
				<span class="input-group-append">
					<span class="input-group-text fa fa-calendar-alt fa-lg"></span>
				</span>
			</div>
			<input type="hidden" id="dtp_input1" value=""/>
			<br/>
		</div>
	</div>
</div>

		<div class="form-group text-center">
			<label class="col-form-label col-md-2 col-sm-12">Priorité :</label>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="priority_RadioBtn" id="EnCours_RadioBtn" value="1" checked>
				<label class="form-check-label" for="level1_RadioBtn">Très urgent</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="priority_RadioBtn" id="Clos_RadioBtn" value="2">
				<label class="form-check-label" for="level2_RadioBtn">Urgent</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="priority_RadioBtn" id="EnCours_RadioBtn" value="3" checked>
				<label class="form-check-label" for="level3_RadioBtn">Normal</label>
		  </div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="priority_RadioBtn" id="Clos_RadioBtn" value="4">
				<label class="form-check-label" for="level4_RadioBtn">Peut attendre</label>
			</div>
		</div>

	<div class="form-group">
		<label class="col-form-label">Commentaire :</label>
		<textarea type="text" class="form-control" name="comment" value="comment" required></textarea>
	</div>

	<div class="form-group">
		<label class="col-form-label">Attribué à :</label>
		<select name = "user_id[]" id="user_id" class="form-control">
			@foreach ($employees as $employee)
				<option value="{{ $employee['id'] }}">{{ $employee['name'] }}</option>
			@endforeach
		</select>
	</div>

<input type="submit" class="btn btn-success btn-h1-spacing float-lg-right" value="Ajouter">
</form>

@endsection


@section('jss')
	@parent
	<script src="{{ asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker.fr.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker-setup.js') }}"  type="text/javascript"></script>
@endsection
