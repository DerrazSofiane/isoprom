@extends('layouts.structure')

@section('csss')
	@parent
	<link rel="stylesheet" href="{{asset('./css/fullcalendar.min.css')}}"/>

@endsection


@section('content')
    <style>
        /* ... */
    </style>

    {!! $calendar_details->calendar() !!}

@endsection

@section('jss')
    @parent
  <!--Scripts du calendrier-->
    <script src="{{asset('./js/moment.min.js')}}"></script>
    <script src="{{asset('./js/fullcalendar.min.js')}}"></script>

    {!! $calendar_details->script() !!}
@endsection
