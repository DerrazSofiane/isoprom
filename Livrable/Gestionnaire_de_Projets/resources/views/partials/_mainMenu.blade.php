
<nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-lg justify-content-between" {{-- style="border:solid 1px green" --}}>
	{{--   <a class="navbar-brand mb-0 h1" href="{{ url('/#') }}"> <!-- logo / brand -->
	<img src="/#" width="30" height="30" class="d-inline-block align-top" alt="">
	ISOPROM : Gestionnaire de projets
	</a> --}}

	<a class="navbar-brand ml-5 mr-5" href="{{url('/')}}">
		<img src="{{url('/')}}/logo_light.png" width="50" height="30" alt="ISOPROM">
	</a>


	@if (!Auth::guest()) <!-- si  authentifié -->

	<button class="navbar-toggler" type="button" data-toggle="collapse"
		data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false"
		aria-label="Toggle navigation" style="">
		<span class="navbar-toggler-icon"></span>
	</button>
	<!--can('index',App\Task::class)   si  employee ou chef-projet -->
	<div class="collapse navbar-collapse" style=" position: relative;" media="" id="navbarColor02">
		{{-- <div class="nav navbar-nav ml-auto " style="border:solid 1px red"> --}}

			<!-- logo / marque / icône -->


			<div class="btn-group mx-3" role="group">
				<!-- Rapport seulement pour Admin, Gérant et Chef de projet -->
				{{-- <a class="btn btn-info" href="">Rapport</a> --}}
				<a class="btn btn-info" href="{{route('calendar.index')}}">Calendrier des Projets</a>


				@can('MyTasks',App\Task::class)
					<a class="btn btn-secondary" href="{{route('Tasks.MyTasks',Auth::user()->id )}}">Mes Taches</a>
        @endcan

				<!--endif-->
				@can('ManagerProjets',App\Project::class)
					<a class="btn btn-secondary" href="{{route('Project.ManagerProjets',Auth::user()->id )}}">Mes Projets</a>
				@endcan
			</div>

			<div class="btn-group" role="group">
				@can('create',App\Task::class)
					<div class="btn-group" role="group">
						<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							Gestion Tâches
						</button>
						<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							<a class="dropdown-item" href="{{route('Tasks.create')}}">Nouvelle Tache</a>
							<a class="dropdown-item" href="{{route('Tasks.index')}}">Liste Taches</a>
						</div>
					</div>
				@endcan

				<div class="btn-group" role="group" aria-label="Button group with nested dropdown">

          @can('index',App\User::class)
						<div class="btn-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								Gestion Utilisateurs
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								<a class="dropdown-item" href="{{route('Users.create')}}">Nouvel Utilisateur</a>
								<a class="dropdown-item" href="{{route('Users.index')}}">Liste Utilisateurs</a>
							</div>
						</div>
					@endcan

					@can('create',App\Project::class)
					<div class="btn-group" role="group">
						<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false"
							style="border-radius:0px;">
							Gestion Projets
						</button>
						<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
							<a class="dropdown-item" href="{{route('Projects.create')}}">Nouveau Projet</a>
							<a class="dropdown-item" href="{{route('Projects.index')}}">Liste des Projets</a>
						</div>
					</div>
				</div>
				@endcan
				<!--else -->
			  @cannot('create',App\Project::class)
				<div class="btn-group" role="group">
				  <a class="btn btn-info" href="{{route('Projects.index')}}">Liste des Projets</a>
        </div>
        @endcannot

				@can('index',App\Client::class) <!-- if(Auth::user()->Auth_hasRole('ADMIN'))-->
				<div class="btn-group" role="group">
					<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						Gestion Clients
					</button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<a class="dropdown-item" href="{{route('Clients.create')}}">Nouveau Client</a>
						<a class="dropdown-item" href="{{route('Clients.index')}}">Liste des Clients</a>
					</div>
				</div>
				@endcan

			</div>

			<!-- notification-->
			<?php $my_notifs = Auth::user()->unreadNotifications; ?>
			<div class="btn-group dropleft ml-5 mx-3 my-1" role="group">
				<i class="btn btn-primary fa fa-bell fa-md py-2"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
					style="border-radius:70%;"
					onclick="$('#notif{{Auth::user()->id}}').click();"
					value="notif">
					<span class="badge badge-danger badge-pill" style="position: absolute;">{{$my_notifs->count()}}</span>
				</i>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
					<!-- toutes les notifications non lues -->
					@foreach ($my_notifs as $ntf)
						<a class="dropdown-item bg-success text-white"
							href="{{route('user.notif.seen',$ntf->id)}}">{{$ntf->data['title']}}</a>
					@endforeach
					<!-- toutes les notifications lues -->
					@foreach (Auth::user()->readNotifications as $ntf)
						<a class="dropdown-item text-secondary"
							href="{{route('user.notif.seen',$ntf->id)}}">{{$ntf->data['title']}}</a>
					@endforeach
				</div>
			</div>

			<!-- utilisateur actuel -->
			<div class="btn-group " role="group" aria-label="Button group with nested dropdown">
				<div class="dropdown show float-right">
					<a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{Auth::user()->name}}
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
						<a class="dropdown-item" href="{{route('Users.show',Auth::user()->id )}}">
							<i class="fa fa-btn fa-user mr-1"></i>Profile</a>
						<a class="dropdown-item" href="#" onclick="$('#logout-form').submit()">
							<i class="fa fa-btn fa-sign-out mr-1"></i>Logout</a>
					</div>
				</div>
			</div>


		{{-- </div> --}}
	</div>

	@endif
</nav>
<br>
<br>
<br>
<div class="container">
	@include('flash::message')

	@if ($errors->any())
	<hr>
			<div class="alert alert-danger">
					<ul>
							@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
							@endforeach
					</ul>
			</div>
	@endif
</div>
<br>
