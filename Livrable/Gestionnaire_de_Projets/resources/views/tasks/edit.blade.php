@extends('layouts.structure')

@section('csss')
	@parent
	<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('fonts/fontawesome/css/all.css') }}" rel="stylesheet">
	<style>
	table.hiden{
		display : none;
	}
	h2{ color: green; }
	</style>
@endsection

@section('content')

 <div class="page-header">
		<div class="form-group align-center">
			     	 <h2>Modifier la tâche </h2>  </div>
</div>
<br><br>
<form role="form" method="post" action="{{route('Tasks.update',$task->id)}}">
	<input type="hidden" name="_method" value="PUT">
	<input type="hidden" name="_token" value="{!! csrf_token() !!}">

	<div class="form-group ml-3">
		<label for="title" class="col-form-label">Sujet :</label>
		<input type="text" class="form-control col-7" name="title" value="{{$task->title}}">

	</div>

	<div class="form-group" style="position: absolute;right:10%;top:25%;">
      <input hidden class="form-check-input" style="float:right" type="checkbox" {{ (($task->state=='VALIDATED')?'checked':'') }} id="valide_state" name="validation">

      <i id="valIcon" class="fas fa-{{ (($task->state=='VALIDATED')?'check-circle text-success':'times-circle text-danger') }} fa-3x"
      	onclick="$(this).toggleClass('fa-{{ (($task->state=='VALIDATED')?'check-circle text-success':'times-circle text-danger') }}');
      			$(this).toggleClass('fa-{{ (($task->state!='VALIDATED')?'check-circle text-success':'times-circle text-danger') }}');
      			$('#valide_state').click();"></i>
      <label class="form-check-label " for="valide_state" >
        Validé
      </label>
    </div>
<div class="form-group form-inline mr-4" style="position: absolute;right:10%;top:50%;">
	<label class="col-form-label mr-3">Etat : </label>
	<div class="form-control" name="state">
	{{ ($task->state=='IN_PROGRESS')?'En-Cours':(($task->state=='FINISHED')?'Fini':(($task->state=='VALIDATED')?'Validé':'empty')) }}
	</div>
</div>


<!-- projet en cours -->
<div class="col-sm">
	<div class="form-row">
		<div class="form-group mr-4 col-4">
			<label class="col-form-label mr-3">Projet attaché :</label>
			<div class="form-control" name="project_id">{{$task->project_title}}</div>
		</div>
	</div>
</div>

	<div class="col">

	<div class="form-group">
		<label for="date_limite" class="col-md-3 col-form-label">Date Limite</label>
		<div class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
			<input id="limitDate" name="limitDate" class="form-control" size="16" type="text" value="{{$task->limitDate}}" readonly>
			<span class="input-group-append">
				<span class="input-group-text fa fa-times fa-lg"></span>
			</span>
			<span class="input-group-append">
				<span class="input-group-text fa fa-calendar-alt fa-lg"></span>
			</span>
		</div>
		<input type="hidden" id="dtp_input1" value=""/><br/>
	</div>

	<div class="form-group">
		<label class="col-form-label col-md-2 col-sm-12">Priorité:</label>
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
</div>

	<div class="form-group ml-3">
		<label class="col-form-label">Commentaire :</label>
		<textarea type="text" class="form-control col-7" name="comment" >{{$task->comment}}</textarea>
	</div><br>


	<div class="col-sm">
	<div class="form-row">
		<div hidden class="form-group form-inline mr-4">
			<label class="col-form-label mr-3">Progression : </label>
			<span id="rangeRes" name="progress" class="badge badge-success badge-pill float-right">{{$task->progress }}</span>
			<input type="hidden" name="progress" value="{{$task->progress }}">
		</div>
	</div>
	</div>

<!--Employés actuels -->
	<h3>Employés actuels:</h3>
	<table class="table table-bordered">
		<thead class="thead-light">
			<tr>
				<th scope="col">Nom</th>
				<th scope="col">Nombre de taches</th>
			</tr>
		</thead>
		<tbody id="currentWorkers">
			@foreach($currentEmployees as $ce)
			<tr id="row_CW_{{$ce->id}}">
				<th scope="row" class="">{{$ce->name}}</th>
				<th scope="row">
				   <span id="rangeRes" class="badge badge-success badge-pill float-center">
				   	{{ $ce->taskCount }}
				   </span>
		    	</th>
				<td class="sm-1">
							<input type="button" id="delete_btn{{$ce->id}}"
							onclick="removeFrom({{$ce->id}}, '{{$ce->name}}', {{$ce->taskCount}})"
							value="X" class="btn btn-danger">
        		</td>
			</tr>
			@endforeach

		</tbody>
	</table>
<br>
<!-- choisir un autre employé -->
	<h3>Autres employés:</h3>
	<table class="table table-bordered">
		<thead class="thead-light">
			<tr>
				<th scope="col">Nom</th>
				<th scope="col">Nombre de taches</th>
			</tr>
		</thead>
		<tbody id="otherEmployees">
			@foreach($otherEmployees as $oe)
			<tr id="row_OE_{{$oe->id}}">
				<th scope="row" class="">{{$oe->name}}</th>
				<th scope="row">
				   <span id="rangeRes" class="badge badge-success badge-pill float-center">
				   	{{ $oe->taskCount }}
				   </span>
		    	</th>
				<td class="sm-1">
							<input type="button" id="add_btn{{$oe->id}}"
							onclick="addTo({{$oe->id}}, '{{$oe->name}}', {{$oe->taskCount}})"
							value="+" class="btn btn-primary">
        		</td>
			</tr>
			@endforeach
		</tbody>
	</table>
		<!--Employés actuels -->
			<input type="hidden" id="addTable" name="addTable" value="">
		<!-- nouvel employé choisi  -->
			<input type="hidden" id="removeTable" name="removeTable" value="">

<button type="submit" name="submit" class="btn btn-success float-right mt-2"><i class="fas fa-save"></i> Enregistrer</button>

</form>
</div>
<hr><br>
@endsection


@section('jss')
	@parent
	<script src="{{ asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker.fr.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap-datetimepicker-setup.js') }}" type="text/javascript"></script>

	<script src="{{ asset('js/responsive_Task_User_Select.js') }}"  type="text/javascript"></script>
	<script src="{{ asset('js/validationEvent.js') }}"  type="text/javascript"></script>

@endsection
