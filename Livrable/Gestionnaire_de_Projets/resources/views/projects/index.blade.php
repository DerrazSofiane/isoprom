@extends('layouts.structure')


@section('content')

<style> h2{ color: green; } </style>
 <div class="page-header">
		<div class="form-group align-center">
      <?php if(isset($func)):?>
        <h2>Mes Projets</h2>
      <?php else: ?>
			<h2>Liste des Projets</h2>
    <?php endif; ?>
    </div>
</div>
<br><br>
<table class="table table-responsive-lg mr-2">
<thead class="thead-dark" >
	<tr>
		<th scope="col">Titre</th>
		<th scope="col">Client</th>
		{{-- <th scope="col">Date debut</th> --}}
    <th scope="col">Date limite</th>
		{{-- <th scope="col">Date fin</th> --}}
			<?php if(isset($func)):?>
			<th scope="col">Déplacement</th>
			<?php else: ?>
			<th scope="col">Chef de Projet</th>
		<?php endif; ?>
		<th scope="col">Etat</th>
		<th scope="col"></th>
		<th scope="col"></th>
		<th scope="col"></th>
	</tr>
</thead>
<tbody>
	@foreach($ps as $p)
    @if($p->state=='clos')
  	<tr class="table-success">
    @else
    <tr>
    @endif

  		<td scope="row">{{$p->title}}</th>
  		<td>{{$p->client_name}}</td>
  		{{-- <td>{{date('Y-m-d', strtotime($p->startDate))}}</td> --}}
      <td>  <div style="color:green;font-weight:bold">{{date('Y-m-d', strtotime($p->limitDate))}}</div></td>

      {{-- <td>{{ ($p->finishDate) ? date("Y-m-d", strtotime($p->finishDate)) : "inachevé"}}</td> --}}


      {{-- <td> <div style="color: blue;font-weight:bold">{{ ($p->finishDate) ? date("M j Y - H:i", strtotime($p->finishDate)) : ""}} </div></td> --}}

			<?php if(isset($func)):?>
	   	<td>{{($p->displacement)?'Oui':'No'}}</td>
		  <?php else: ?>
			<td>{{$p->chef}}</td>
		  <?php endif; ?>
  		<td>{{($p->state)?'en-cours':'clos'}}</td>
  		<td>
  		<td>
        <td scope="row">
          <form action="{{ route('Projects.show',$p->id) }}" id="show{{$p->id}}" method="get"></form>
          <form action="{{ route('Projects.edit',$p->id) }}" id="edit{{$p->id}}" method="get"></form>
          <form action="{{ route('Projects.destroy',$p->id) }}" id="delete{{$p->id}}" method="post">
            {!! method_field('delete') !!}{!! csrf_field() !!}
          </form>
          <div class="btn-group" role="group" aria-label="Basic example">
            <i class="btn btn-success fa fa-eye text-dark" aria-hidden="true"
              onclick="$('#show{{$p->id}}').submit();" value="v"></i>
						@if(!Auth::user()->Auth_hasRole('EMPLOYEE'))
              @if($p->state!=0)<!--ompossible d'éditer un projet clos -->
            <i class="btn btn-primary fas fa-pencil-alt text-dark" aria-hidden="true"
              onclick="$('#edit{{$p->id}}').submit();" value="m"></i>
            <!--<i class="btn btn-danger fas fa-times text-dark" onclick="$('#delete{{$p->id}}').submit();" value="s"></i>-->
              @endif
            @endif
          </div>
        </td>
        {{--
          can('edit',Auth::user())
  				<input type="submit" class="btn btn-primary" onclick="$('#edit{{$p->id}}').click();" value="m">
          endcan
          can('delete',Auth::user())
        	<input type="submit" class="btn btn-danger" onclick="$('#delete{{$p->id}}').click();" value="s">
          endcan--}}
  	</tr>
	@endforeach
</tbody>
</table>

@if(!$ps)
  <div class="alert alert-secondary fade show align-center form-inline" role="alert">
     Aucun Projet
  </div>
@endif

@endsection
