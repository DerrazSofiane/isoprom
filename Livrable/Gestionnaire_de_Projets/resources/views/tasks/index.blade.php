@extends('layouts.structure')

@section('content')
<br>
<style> h2{ color: green; } </style>
 <div class="page-header">
		<div class="form-group align-center">
			     	 <h2>Tout les Taches </h2>  </div>
</div>
<br><br>
<table class="table table-responsive-lg  mr-2">
<thead class="thead-dark">
	<tr>
		<th scope="col">Projet relié</th>
		<th scope="col">Description</th>
		<th scope="col">Date debut</th>
		<th scope="col">Date limite</th>
		<th scope="col">Priorité</th>
		<th scope="col">Etat</th>
		<th scope="col">%</th>{{-- Déroulement --}}
		{{-- <th>commentaire</th> --}}
		<th scope="col"></th>
	</tr>
</thead>
<tbody>
	@foreach($ts as $t)
    @if($t->state=='FINISHED')
  	<tr class="table-info">
    @elseif($t->state=='VALIDATED')
    <tr class="table-success">
    @else
   	<tr>
		@endif

		<td>{{$t->project_title}}</td>
		<td><b>{{substr($t->title,0,15)}} {{(strlen($t->title)>15)?'...':'.' }}</b></td>
		<td>{{($t->d_d)?date('d-m-Y', strtotime($t->d_d)):'-'}}</td>
		<td><div style="color:blue;font-weight:bold">{{date('d-m-Y', strtotime($t->limitDate))}}</div></td>
	    <td>
	      @if($t->priority==1)
	        <div style="color:red;font-weight:bold">
	        @elseif($t->priority==2)
	          <div style="color:orange;font-weight:bold">
	          @elseif($t->priority==3)
	            <div style="color:yellow;font-weight:bold">
	              @else
	                <div style="color:green;font-weight:bold">
	      @endif
	    		@if($t->priority==1)
	          Très Urgent
	          @elseif($t->priority==2)
	             Urgent
	               @elseif($t->priority==3)
	                 Normal
	                  @else  Peut attendre
	        @endif
	      </div>
	    </td>
	  	<td>
	      <p class="card-text" name="state">
	      {{($t->state=='IN_PROGRESS')?'En-Cours':(($t->state=='FINISHED')?'Fini':(($t->state=='VALIDATED')?'Validée':'empty'))}}
	      </p>
	    </td>
		<td>{{$t->progress}}</td>
		<td scope="row">
			<form action="{{ route('Tasks.show',$t->id) }}" id="show{{$t->id}}" method="get"></form>
			<form action="{{ route('Tasks.edit',$t->id) }}" id="edit{{$t->id}}" method="get"></form>
			</form>
			<div class="btn-group" role="group" aria-label="Basic example">
				<i class="btn btn-success fa fa-eye text-dark" aria-hidden="true" onclick="$('#show{{$t->id}}').submit();"></i>
          @if($t->project_state!=0)<!--impossible d'éditer une tâche dans un projet clos -->
				<i class="btn btn-primary fas fa-pencil-alt text-dark" aria-hidden="true" onclick="$('#edit{{$t->id}}').submit();"></i>
          @else
          <div class="ml-1" style="font-style: italic; color:blue;"> Projet clos </div>
          @endif
		 </div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>
@if(empty($ts))
  <div class="alert alert-secondary fade show align-center form-inline" role="alert">
     Aucune tache
  </div>
@endif
@endsection
