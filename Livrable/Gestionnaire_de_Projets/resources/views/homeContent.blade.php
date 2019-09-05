
<style>
{{--@media only screen and (max-width: 1222px) {
    /* Pour les téléphones mobiles:*/
    [class*="col-"] {
        width: 100%;
    }
}--}}
</style>
<br>

<div class="form-row ">
  <div class="form-group col-md-4 col-sm-12 text-center">
  <!--display calendar -->
    @include('Calendars.mycalendar')

  </div>
	<div id="lastItems" class="form-group col-md-12  col-sm-12">
    <div class="form-group">
      <div class="col-lg-12"> </div>
      <div class="col-lg-12 h1">Bienvenu {{Auth::user()->name}} </div>
    </div>
    <br>
    <hr>
    <div class="row">
      <div class="col-md-12">
        <h4>Derniers Projets :</h4>
        @foreach($LastFewProjects as $p)
          <div class="alert alert-info alert-dismissible fade show form-inline " role="alert">
            <div class="font-weight-bold col-lg-3">{{$p->title}}</div>
            <div class="font-weight-bold col-lg-3">{{($p->state)?'En-Cours':'Clos'}}</div>
            <div class="font-weight-bold col-lg-3" style="border-style: solid;border-top-style: none;border-left-style: none;">  Dernière modification: </div>
            <div class="font-weight-bold col-lg-3"> {{$p->updated_at}} </div>


            {{--   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button> --}}
          </div>
        @endforeach
        <h4>Dernières Tâches :</h4>
        @foreach($LastFewTasks as $t)
        <div class="alert alert-warning alert-dismissible fade show form-inline" role="alert">
          <div class="font-weight-bold col-lg-3">{{$t->title}}</div>
            <div class="font-weight-bold col-lg-3">
              <p class="card-text" name="state">
              {{($t->state=='IN_PROGRESS')?'En-Cours':(($t->state=='FINISHED')?'Fini':(($t->state=='VALIDATED')?'Validée':'empty'))}}
              </p>
            </div>

          <div class="font-weight-bold col-lg-2" style="border-style: solid;border-top-style: none;border-left-style: none;">  Dernière modification: </div>
          <div class="font-weight-bold col-lg-3"> {{$t->updated_at}} </div>
          <a class="close" href="./Tasks/{{$t->id}}">
            <span class="badge badge-default badge-pill" >
              @if($t->priority==1)
     						 <div style="color:red;font-weight:bold;" class="ml-8 ">~ Très Urgent ~</div>
     					 @elseif($t->priority==2)
     							 <div style="color:orange;font-weight:bold;" class="ml-8 ">~ Urgent ~</div>
     								@elseif($t->priority==3)
     									 <div style="color:yellow;font-weight:bold;" class="ml-8 ">~ Normal ~</div>
     									 @else
     											<div style="color:#098812 ;font-weight:bold;" class="ml-8">~ Peut attendre ~</div>
     				  @endif
            </span>
          </a>
        </div>
        @endforeach
      </div>

    </div>
  </div>
</div>
</div>
