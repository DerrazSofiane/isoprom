@extends('layouts.structure')
@section('csss')
    @parent
 {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css" /> --}}

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="{{ asset('fonts/fontawesome/css/all.css') }}" rel="stylesheet">

@endsection

@section('content')
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
                    <th>Action</th>
                    <th>
                        <button type="button" id="mass_delete"
                        name="mass_delete" class="btn btn-danger btn-xs" style="font-size: 0.5rem;">
                            <i class="fa fa-times fa-lg"></i>
                        </button>


                    </th>
                </tr>
            </thead>
        </table>
@endsection

@section('jss')
@parent

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}



<script>
$(function() {



    $('#myTable').DataTable(
    {
        serverSide: true,
        ajax: '{!! route('datatables.getdata',$current) !!}',
        columns: [
            <?php
                $ch="";
                foreach ($cols as $c) {
                    $ch = $ch . '{ "data": "'.$c.'" },';
                }
                echo $ch;
            ?>

            { "data": "action", orderable:false, searchable: false},
            { "data":"checkbox", orderable:false, searchable:false}
        ]
    }
    );


    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("Êtes-vous sûr de vouloir supprimer ces données?"))
        {
            $.ajax({
                url:"{{route('datatables.removedata',$current)}}",
                mehtod:"get",
                data:{id:id},
                success:function(data)
                {
                    alert(data);
                    $('#myTable').DataTable().ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    });

    $(document).on('click', '#mass_delete', function(){console.log('start');
        var id = [];
        if(confirm("Êtes-vous sûr de vouloir supprimer ces données?"))
        {
            $('.obj_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            console.log(id);
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{ route('datatables.massremove',$current)}}",
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        alert(data);
                        $('#myTable').DataTable().ajax.reload();
                    }
                });
            }
            else
            {
                alert("Veuillez sélectionner au moins une case à cocher");
            }
        }
    });
     var selected = [];

        // "rowCallback": function( row, data ) {
        //     if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
        //         $(row).addClass('selected');
        //     }
        // }

    $('#myTable tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selected);

        if ( index === -1 ) {
            selected.push( id );
        } else {
            selected.splice( index, 1 );
        }

        $(this).toggleClass('selected');
    } );
});
</script>
@endsection
