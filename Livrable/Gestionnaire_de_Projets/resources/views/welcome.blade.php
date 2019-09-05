@extends('layouts.structure')
@section('csss')
    {{-- @parent --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> --}}
    <link href="{{ asset('fonts/fontawesome/css/all.css') }}" rel="stylesheet">
   <style>
         @media only screen and (min-width: 601px) {
            body {
                /*background-color: seagreen;*/
            }
            #myBtn-group{
                position: fixed;right: 3%;top:50%;
            }
        }
        @media only screen and (max-width: 600px) {
            body {
                /*background-color: lightblue;*/
            }
            #myBtn-group{
                position: fixed;left:25%; top: 10%;
            }
        }
     /*  .myBtn-group{
            position: relative;
            top:60%;
            left:30%;
       }*/
       table.dataTable tbody tr.selected{background-color:#B0BED9;}

   </style>
@endsection

@section('content')

@include('flash::message')

   {{--  <div style="position: fixed;left:25%; top: 10%">

    </div> --}}

{{-- management buttons --}}
    <input type="hidden" value="empty" disabled id="selectedIds" class="float-right" style=";">

    <form action="{{ route($current.'.create') }}" id="form_add" method="get"></form>
    <form action="" id="form_show" method="get"></form>
    <form action="" id="form_edit" method="get"></form>
    <div class="btn-group btn-group-lg text-light" id="myBtn-group"
        style="z-index:10;"
        {{-- style="position: relative;left:25%; top: 50%"  --}}
        {{-- style="position: fixed;right: 3%;top:50%;" --}}>

        <button id="btn_new" class="btn btn-warning text-dark" onclick="$('#form_add').submit();" value="Ajouter">
            <i class="fas fa-plus"></i>
        </button>
        <button id="btn_show" class="btn btn-success text-dark" onclick="$('#form_show').submit();" value="Afficher" disabled>
            <i class="far fa-eye"></i>
        </button>
        <button id="btn_edit" class="btn btn-primary text-dark" onclick="$('#form_edit').submit();" value="Modifier" disabled>
            <i class="fas fa-pencil-alt"></i>
        </button>
      {{--   <button type="button" id="mass_delete" class="btn btn-secondary text-dark" disabled>
            <i class="fas fa-file-archive"></i>
        </button> --}}
    </div>
{{-- </div> --}}
{{--  --}}

        <table class="text-center table table-responsive-lg table-hover" style="width:100%" id="myTable">
            <thead class="">
                <tr style="font-size:16px">
                    <?php
                        $ch="";
                        foreach ($cols as $c) {
                            $ch = $ch . '<th>'.ucfirst($c).'</th>';
                        }
                        echo $ch;
                    ?>
                </tr>
            </thead>
        </table>
@endsection

@section('jss')
@parent

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



<script>
$( document ).ready(function() {

    var selected = [];

    var table = $('#myTable').DataTable({
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
                "sortDescending": ": activer pour trier par ordre décroissant"
            }
        },
        serverSide: true,
        ajax: '{!! route('datatables.getdata',$current) !!}',
         "rowCallback": function( row, data ) {
            if ( $.inArray(data.id, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        },
        columns: [
            <?php
                $ch="";
                foreach ($cols as $c) {
                    $ch = $ch . '{ "data": "'.$c.'" },';
                }
                echo $ch;
            ?>
            // { "data": "action", orderable:false, searchable: false},
            // { "data":"checkbox", orderable:false, searchable:false}
        ]
    });

    // $(document).on('click', '.delete', function(){
    //     var id = $(this).attr('id');
    //     if(confirm("Êtes-vous sûr de vouloir supprimer ces données?"))
    //     {
    //         $.ajax({
    //             url:"{route('datatables.removedata',$current)}}",
    //             mehtod:"get",
    //             data:{id:id},
    //             success:function(data)
    //             {
    //                 alert(data);
    //                 $('#myTable').DataTable().ajax.reload();
    //             }
    //         })
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // });

    $(document).on('click', '#mass_delete', function(){console.log(selected);
        if(selected.length > 0)
        {
            if(confirm("Êtes-vous sûr de vouloir supprimer ces données?"))
            {
                // $('.obj_checkbox:checked').each(function(){
                //     id.push($(this).val());
                // });
                // console.log(id);
                    $.ajax({
                        url:"{{ route('datatables.massremove',$current)}}",
                        method:"get",
                        data:{id:selected},
                        // error:function(data){
                        //     console.log('error\n'+data);
                        // },
                        success:function(data)
                        {
                            console.log(data);
                            // alert(data);
                            $('#myTable').DataTable().ajax.reload();
                        }
                    });
            }
        }else alert("Veuillez sélectionner au moins une ligne");
    });

        // "rowCallback": function( row, data ) {
        //     if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
        //         $(row).addClass('selected');
        //     }
        // }

    $('#myTable tbody').on('click', 'tr', function () {
        var id = table.row(this).data().id;
        var index = $.inArray(id, selected);

        if ( index === -1 ) {
            selected.push( id );
        } else {
            selected.splice( index, 1 );
        }

        $('#mass_delete').prop("disabled", (!selected.length>0));

        $('#btn_show,#btn_edit').prop("disabled", (selected.length!=1));
        if (selected.length==1) {generateActions();}
        $('#selectedIds').val(selected);

        $(this).toggleClass('selected');
    } );
    function generateActions(){
        var myUrl = '{{ url('/').'/'.$current.'/'}}';
        $('#form_show').attr('action',myUrl+selected[0]);
        $('#form_edit').attr('action',myUrl+selected[0]+'/edit');
        console.log(myUrl+'show/'+selected[0]);
        console.log(myUrl+'edit/'+selected[0]);
    }
    function myFunction(x) {
        if (x.matches && !$('#myBtn-group').hasClass('btn-group-vertical')) { // Si la requête média correspond
            /* La fenêtre de visualisation a une largeur inférieure ou égale à 600 pixels. */
            $('#myBtn-group').toggleClass('btn-group').toggleClass('btn-group-vertical');
        }
    }

    var mylistener = window.matchMedia("(max-width: 600px)");
    myFunction(mylistener); // Fonction d'écoute des appels au moment de l'exécution
    mylistener.addListener(myFunction); // Attacher une fonction d'écoute aux changements d'état
});
</script>
@endsection
