@extends('layouts.structure')

@section('content')
<style>
h1{border-bottom:1px ;color: grey;}
input[type=text] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: none;
    background-color: #3CBC8D;
    color: white;
		font-weight: bold;
}

.big_box{
    width: 100%;
    height: 150px;
    padding: 12px 20px;
    box-sizing: border-box;
    border: 2px solid #3CBC8D;
    border-radius: 4px;
    background-color: #f8f8f8;
    font-size: 16px;
    resize: none;
    overflow :auto;
}
.small_box {

	width: 100%;
	height: 40px;
	padding: 5px 5px;
	text-align: center;
	box-sizing: border-box;
	border: 2px solid #3CBC8D;
	border-radius: 4px;
	background-color: #f8f8f8;
	font-size: 16px;
	resize: none;

}
</style>

<div class="form-group align-center">
	<h1>{{ $task->title }} </h1>
</div>

@can('edit',App\Task::class)
  @if($project->state==1)<!--impossible d'éditer une tâche dans un projet clos -->
  <form action="{{ route('Tasks.edit',$task->id) }}" method="get">
  	<button type="submit" class="btn btn-primary float-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifier</button>
  </form>
  @endif
@endcan
<br><hr><br>

	<form action="{{ route('Tasks.updateProgress',$task->id) }}" method="post">
		<input type="hidden" name="_method" value="PUT">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<div class="form-group form-row">
		 <label  class="form-inline mr-2" for="priority">Priorité :</label>
		  <label class="small_box" id="priority" name="priority" >
				 @if($task->priority==1)
						 <div style="color:red;font-weight:bold" class="ml-8 ">~ Très Urgent ~</div>
					 @elseif($task->priority==2)
							 <div style="color:orange;font-weight:bold;background-color:gray" class="ml-8 ">~ Urgent ~</div>
								@elseif($task->priority==3)
									 <div style="color:yellow;font-weight:bold;background-color:gray" class="ml-8 ">~ Normal ~</div>
									 @else
											<div style="color:green;font-weight:bold;" class="ml-8">~ Peut attendre ~</div>
				 @endif
      </label>
		   <label for="proj">Projet attaché :</label>
		   <input type="text" id="proj" name="proj" value="{{ $project->title }}">
		   <label for="comment">commentaire :</label>
		   <textarea class="big_box"id="comment" name="comment" >{{ $task->comment }}</textarea>
			 <label for="state">Etat :</label>
		   <input type="text" id="state" name="state"
			 value="~ {{($task->state=='IN_PROGRESS')?'En-Cours':(($task->state=='FINISHED')?'Fini':(($task->state=='VALIDATED')?'Validée':'empty'))}} ~">
		</div>
			<div class="col-sm">
				<div class="form-row">
					<div class="form-group ">
						<div class="card mr-3" style="width: 30rem;">
							<div class="card-body form-inline ">
								<h5 class="card-title  mr-4">Date Limite :</h5>
								<p class="card-text float-right">{{date("M j Y h:m:s", strtotime($task->limitDate))}}</p>
							</div>
						</div>
					</div>
				<!--barre de progression -->
				<div class="form-group">
					<div class="card mr-4"style="width: 30rem;">
						<div class="card-body form-inline">
							<h5 class="card-title mr-3">Progression:</h5>

  							@can('updateProgress',[App\Task::class,$task])<!--!! seul un travailleur peut éditer l'avancement -->
                  @if($project->state==1)<!--impossible d'éditer une tâche dans un projet clos-->
  							 	<input type="range" id="RangeProgress" name="progress" step="5" oninput="$('#rangeRes').html($('#RangeProgress').val());"  onchange="$('#saveBtn').show();" value="{{$task->progress}}">
                  @endif
                @endcan
								@cannot('updateProgress',[App\Task::class,$task]) <!--la progression désactivé est montrée aux autres visiteurs -->
							    <input disabled type="range" id="RangeProgress" step="5" oninput="$('#rangeRes').html($('#RangeProgress').val());" value="{{$task->progress}}">
								@endcannot
							<span id="rangeRes" class="badge badge-success badge-pill float-right">{{$task->progress }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		@can('updateProgress',[App\Task::class,$task])
      <!--!!le bouton est caché et apparaît quand on modifie -->
			 <button  id="saveBtn" type="submit" name="submit" style='display:none;' class="btn btn-success float-right mr-4"><i class="fa fa-floppy-o" aria-hidden="true" > Enregistrer </i></button>

  	@endcan
		</form>
		<br>
		<br>
		<!--si l'utilisateur a autorisé l'action, il peut ajouter des travailleurs pour cette tâche -->
    <!-- ajout d'employés -->
    {{-- @if(!Auth::user()->Auth_hasRole('EMPLOYEE'))
      @if($project->state!=0)<!--impossible d'éditer un projet clos -->
      	<form action="{{ route('Tasks.addTaskEmpl',$project->id) }}" method="get">
      		<button type="submit" class="btn btn-warning float-right"><i class="fa fa-plus" aria-hidden="true"></i></button>
      	</form>
      @endif
  	@endif  --}}
		<h3>Employés reliés:</h3>
		<table class="table table-bordered">
			<thead class="thead-light">
				<tr>
					<th scope="col">Nom</th>
					<th scope="col">Email</th>
					<th scope="col">Commentaire</th>
			{{-- 		<th scope="col">Date Debut</th>
					<th scope="col">Date Fin</th> --}}
				</tr>
			</thead>
			<tbody>
				@foreach($users as $u)
				<tr>
					<th scope="row" class="">{{$u->name}}</th>
					<th scope="row">{{$u->email}}</th>
					<th scope="row">{{$u->comment}}</th>
			{{-- 		<td scope="row">{{date("F j Y H:i", strtotime($u->startDate))}}</td>
					<td scope="row">{{date("F j Y H:i", strtotime($u->finishDate))}}</td> --}}
				</tr>
				@endforeach
			</tbody>
		</table>
		<hr>

		@endsection

		@section('jss')
		@parent

		@endsection
