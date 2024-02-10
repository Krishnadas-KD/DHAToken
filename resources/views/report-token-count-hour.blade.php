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
                <p class="grid-header">Token Counter Hour wise</p>
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
                                <table id="ReportTable" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                        
                                        </tr>
                                    </thead>
                                </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="grid">
                <p class="grid-header">Token Count Counter Wise</p>
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
                                <table id="ReportTable2" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                        
                                        </tr>
                                    </thead>
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
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $( "#loadbtn" ).click(function() {
      
        $("#loader").removeClass( "d-none" )
        $('#ReportTable').DataTable({
            "processing": true,
            "destroy": true,
            "serverSide": true,
            "ajax": {
                    "url": "{{ route('token_list') }}",
                    "type": "POST",
                    "headers": {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    "data": function (d) {
                        d.from = $('#fromDate').val();
                        d.to = $('#toDate').val();
                    }
                },
                "pageLength": 10,  
                "lengthMenu": [10, 25, 50, 75, 100],
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ], 
                "columns": [
                {"data": "id","title":"Token ID"},
                {"data": "token_name","title":"Token"},
                {"data": "type","title":"Type"},
                {"data": "section","title":"Section"},
                {"data": "post_date","title":"Date"},
                {"data": "token_status","title":"Status"},
                {"data": "created_at","title":"Create at"},
                {"data": "last_updated","title":"Last Update"}
            ]
        });
        $("#loader").addClass( "d-none" )


    });

});
</script>

@endsection('script')

