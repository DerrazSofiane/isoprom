@extends('layouts.structure')

@section('csss')
	@parent
	<link href="{{ asset('fonts/fontawesome/css/all.css') }}" rel="stylesheet">
	<style> h2{ color: green; } i{padding-top: 10%;}</style>
	    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')

<style> h2{ color: green; } </style>
 <div class="page-header">
		<div class="form-group align-center">
			     	 <h2>Liste des Clients</h2>  </div>
</div>
<br><br>

<div class="float-right">
  <a class="nav-link" href="{{ route('Clients.create') }}">Nouveau Client</a>
</div>

<table class="table" id="dtTest">
<thead>
	<tr>
		<th scope="col" class="d-none d-lg-block" style="border-bottom:none;">Email</th>
		<th scope="col">Numéro d'enregistrement</th>
		<th scope="col" class="d-none d-lg-block" style="border-bottom:none;">Téléphone</th>
		<th scope="col">Nom</th>
		<th scope="col" class="d-none d-lg-block" style="border-bottom:none;">Commentaire</th>
		<th scope="col"></th>
	</tr>
</thead>
<tbody>
	@foreach($clients as $c)
	<tr>
		<td scope="row" class="d-none d-lg-block">{{$c->email}}</th>
		<th scope="row">{{$c->registrationNumber}}</th>
		<td scope="row" class="d-none d-lg-block">{{$c->phoneNumber}}</th>
		<td scope="row">{{$c->name}}</th>
		<td scope="row" class="d-none d-lg-block">{{$c->comment}}</th>
		<td scope="row">
			<form action="{{ route('Clients.show',$c->id) }}" id="show{{$c->id}}" method="get"></form>
			<form action="{{ route('Clients.edit',$c->id) }}" id="edit{{$c->id}}" method="get"></form>
			<form action="{{ route('Clients.destroy',$c->id) }}" id="delete{{$c->id}}" method="post">
				{!! method_field('delete') !!}{!! csrf_field() !!}
			</form>
			<div class="btn-group" role="group" aria-label="Basic example">
				<i class="btn btn-success far fa-eye text-dark" onclick="$('#show{{$c->id}}').submit();" value="v"></i>
				<i class="btn btn-primary fa fa-pencil-alt text-dark" onclick="$('#edit{{$c->id}}').submit();" value="m"></i>
				{{-- <i class="btn btn-danger fas fa-times text-dark" onclick="$('#delete{{$c->id}}').submit();" value="s"></i> --}}
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>
@endsection

@section('jss')
@parent

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}



<script>
	$('#dtTest').dataTable({
		language: {
			"decimal":        "",
			"emptyTable":     "Aucune donnée disponible.",
			"info":           "Afficher de _START_ à _END_ de _TOTAL_ entrées",
			"infoEmpty":      "Afficher 0 à 0 de 0 entrées",
			"infoFiltered":   "(filtré à partir des entrées totales _MAX_)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Afficher _MENU_ entrées",
			"loadingRecords": "Chargement...",
			"processing":     "En cours de traitement...",
			"search":         "Chercher:",
			"zeroRecords":    "Aucun enregistrements correspondants trouvés",
			"paginate": {
				"first":      "Premier",
				"last":       "Dernier",
				"next":       "Suivant",
				"previous":   "Précédent"
			},
			"aria": {
				"sortAscending":  ": activer pour trier par ordre croissant",
				"sortDescending": ": activer pour trier par ordre décroissant"
			}
		}
	});
</script>

@endsection
