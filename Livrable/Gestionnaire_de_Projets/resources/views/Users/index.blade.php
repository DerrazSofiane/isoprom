@extends('layouts.structure')

@section('jss')
@parent
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script>
$(document).ready( function () {
	$('#users_table').DataTable({
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
				"next":       "Prochain",
				"previous":   "Précédent"
			},
			"aria": {
				"sortAscending":  ": activer pour trier par ordre croissant",
				"sortDescending": ": activer pour trier par ordre descendant"
			}
		}
	});
} );
</script>
@endsection

@section('csss')
	@parent
	<style> h2{ color: green; } i{padding-top: 10%;}</style>
@endsection

@section('content')

 <div class="page-header">
		<div class="form-group align-center">
			     	 <h2>Liste des utilisateurs</h2>  </div>
</div>
<br><br>
<table class="table table-responsive-lg" id="users_table" data-order='[[ 1, "asc" ]]' data-page-length='5'>
<thead>
	<tr>
		<th scope="col">Nom</th>
		<th scope="col" class="d-none d-lg-block" style="border-bottom:none;">Email</th>
		{{-- <th scope="col">mot de passe</th> --}}
		<th scope="col">Rôle</th>
		<th scope="col" class="d-none d-lg-block" style="border-bottom:none;">Commentaire</th>
		<th scope="col"></th>

	</tr>
</thead>
<tbody>
	@foreach($users as $u)
	<tr>
		<th scope="row">{{$u->name}}</th>
		<td scope="row" class="d-none d-lg-block">{{$u->email}}</th>
		{{-- <td scope="row">{{$u->password}}</th> --}}
		<td scope="row">
			{{
				($u->role=='EMPLOYEE')?'Employé':(($u->role=='MANAGER')?'Gérant':(($u->role=='PROJECT_MANAGER')?'Chef de Projet':'Admin'))
			}}
		</th>
		<td scope="row" class="d-none d-lg-block">{{$u->comment}}</th>
		<td scope="row">
			<form action="{{ route('User.Profile',$u->id) }}" method="get">
				<input hidden type="submit" id="show{{$u->id}}" class="btn btn-primary">
			</form>
			<form action="{{ route('Users.edit',$u->id) }}" method="get">
				<input hidden type="submit" id="edit{{$u->id}}" class="btn btn-primary">
			</form>
			<form action="{{ route('Users.destroy',$u->id) }}" method="post">
				{!! method_field('delete') !!}
				{!! csrf_field() !!}
				<input hidden type="submit" class="btn btn-danger" id="delete{{$u->id}}">
			</form>
			<div class="btn-group" role="group" aria-label="Basic example">
        @if(Auth::user()->Auth_hasRole('ADMIN')||Auth::user()->Auth_hasRole('MANAGER'))
          @if($u->role!='ADMIN')<!--ne pas modifier l'admin -->
				<i class="btn btn-success fa fa-eye text-dark" aria-hidden="true" onclick="$('#show{{$u->id}}').click();"
					{{-- id="voir{{$u->id}}"
					onmouseover="$('#voir{{$u->id}}').val('voir');"
					onmouseout="$('#voir{{$u->id}}').val('v');" --}}
				value="v"></i>
          @endif
        @endif
        <!--can('edit',App\User::class,$u)-->
      	@if(Auth::user()->Auth_hasRole('ADMIN')||Auth::user()->Auth_hasRole('MANAGER'))
          @if($u->role!='ADMIN')<!--ne pas modifier l'admine -->
				  <i class="btn btn-primary fas fa-pencil-alt text-dark" aria-hidden="true" onclick="$('#edit{{$u->id}}').click();" value="m"></i>
          @endif
        @endif
        <!--can('delete',App\User::class,$u)-->
        @if(Auth::user()->Auth_hasRole('ADMIN')||Auth::user()->Auth_hasRole('MANAGER'))
          @if($u->role!='ADMIN')<!--ne pas modifier l'admine -->
				  {{-- <i <i class="btn btn-secondary fas fa-file-archive text-dark" aria-hidden="true" onclick="$('#delete{{$u->id}}').click();" value="s"></i> --}}
          @endif
        @endif
      </div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>
@endsection
