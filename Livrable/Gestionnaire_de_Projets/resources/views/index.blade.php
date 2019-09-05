@extends('layouts.structure')


@section('content')

		@if(Auth::guest())

				  @include('auth.loginForm')

		@else
		      @include('homeContent')
		@endif

		@endsection

@section('jss')
		@parent
			<script>
				$('.alert').on('click',function(){
					console.log('printing');
				});
			</script>
@endsection
