@extends('base')

@section('title')
    Dashboard
@endsection('title')

@section('style-css')
    <style>
        table.info-table tr th, td {
            text-align: left !important;
        }
       
    </style>
@endsection('style-css')

@section('content')
<div class="content-viewport">

    <div class="row">
        <div class="col-lg-12">
            <div class="grid">
                <p class="grid-header">Awaiting Customer List</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="table-responsive">
                            <table class="table info-table table-bordered" id="customerTab">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Date</th>
                                        <th>Date</th>
                                        <th>Service</th>
                                        <th>Token</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $customers->firstItem()+$loop->index }} </td>
                                            <td>{{ date('d-m-Y', strtotime($customer->created_at)) }} </td>
                                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->addHours(4)->format('h:i:s a') }} </td>
                                            <td>{{ $customer->service_name }}</td>
                                            <td>{{ $customer->token_str }}</td>
                                            <td>{{ $customer->customer_phone}}</td>
                                            <td><div class="badge badge-warning">Awaiting</div></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="d-felx justify-content-center mt-3">


                                {{ $customers->links('pagination::bootstrap-4') }}

                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@stop


@section('script')

{{-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script> --}}


<script>
    $(document).ready( function () {
       // $('#customerTab').DataTable();

        $('#customerTab').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });


    } );
</script>


@endsection('script')
