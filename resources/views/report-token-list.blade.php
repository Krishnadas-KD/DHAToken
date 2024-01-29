@extends('base')

@section('title')
    Token List
@endsection('title')


@section('style-css')
    <style>
        #TokenCount td
        {
            text-align: left;
            vertical-align: middle;
        }
        #TokenCount th
        {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    @include('datatable-css');
@stop('style-css')

@section('content')
<div class="content-viewport">

    <div class="row">
        <div class="col-lg-12">
            <div class="grid">
                <p class="grid-header">Token List</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="row showcase_row_area">
                            <div class="col-lg-3 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">FROM</label>
                                    <input id="fromDate" class="form-control" type="date"  name="" required>
                                </div>
                            </div>
                            <div class="col-lg-3 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">TO</label>
                                    <input id="toDate" class="form-control" type="date" name="" required>
                                </div>
                            </div>
                            <div class="col-lg-2 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">&nbsp;</label>
                                    <div class="form-control btn btn-primary btn-sm has-icon" id="loadbtn" style="color: white;"><i class="mdi mdi mdi-autorenew"></i>Reload</div>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table info-table table-bordered" id="TokenCount">
                                <thead>
                                    <tr>
                                        <th>Token ID</th>
                                        <th>Token</th>
                                        <th>Type</th>
                                        <th>Section</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Create at</th>
                                        <th>Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop


@section('data-table')
    @include('datatable');
@endsection('data-table')


@section('script')

<script>

$(document).ready(function(){
    
    var table = $('#TokenCount').DataTable({
        responsive:true,
        pageLength:15,
        dom: 'Bfrtip',
        buttons: [
        'excel', 'pdf', 'print'
    ]
    });
    $("#fromDate").val(new Date().toISOString().split('T')[0])
    $("#toDate").val(new Date().toISOString().split('T')[0])

    $( "#loadbtn" ).click(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var from = $('#fromDate').val();
    var to = $('#toDate').val();

    var url = '{{ route('token_list') }}';
    table.clear().draw();
    $.ajax({
        type:"POST",
        url: url,
        data: {'from':from,'to':to},
        beforeSend: function() {
            $("#loader").removeClass( "d-none" )

        },
        success:function(response) {
            var arr = response.data;
            for (i = 0; i < arr.length; ++i) {
                table.row
                    .add([
                        arr[i].id,
                        arr[i].token_name,
                        arr[i].type,
                        arr[i].section,
                        arr[i].post_date,
                        arr[i].token_status,
                        arr[i].created_at.getTime(),
                        arr[i].last_updated
                    ]).draw();
                    
                    
            }
            $("#loader").addClass( "d-none" )
        },
        error:function(response) {

            $("#loader").addClass( "d-none" )
        }
    });
    });

});
</script>

@endsection('script')

