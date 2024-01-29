@extends('base')
@section('title')
    Assign Counter

@endsection('title')

@section('content')
<div class="content-viewport">
    <div class="row">
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">Assign Counter</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('assign_counter_no') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Counter</label>
                                        <select class="custom-select" name="counter_id">
                                            @foreach ($counters as $counter)
                                                <option value="{{ $counter->id }}">{{ $counter->counter_name }} - {{ $counter->counter_number }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="crt_user">
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Service</label>
                                        <select class="custom-select" name="service_id">
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">Counters</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="grid table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Counter name</th>
                                         <th>Counter number</th>
                                        <th>Service</th>
                                        
                                        {{-- <th>Edit</th> --}}
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counterservices as $counterservice)
                                        <tr>
                                            <td>
                                                <p class="mb-n1 font-weight-medium">{{ $loop->index+1 }}</p>
                                            </td>
                                            <td class="font-weight-medium">{{ $counterservice->counter_name }}</td>
                                              <td class="font-weight-medium">{{ $counterservice->counter_number }}</td>

                                            <td class="font-weight-medium">{{ $counterservice->service_name }}</td>

                                          
                                            <td class="text-danger font-weight-medium">
                                                <form action="{{ route('delete_ass_counter',$counterservice->id) }}" method="post">
                                                    @csrf

                                                    <button type="submit" class="btn btn-outline btn-sm show_confirm"><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>

</style>
@stop

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {

      $('#example').DataTable(
         {"lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ], // Set available page lengths
        "pageLength": 5, // Set initial page length to 5
        "paging": true, // Enable pagination
        "ordering": true, // Enable column sorting
        "info": true // Display info (e.g., "Showing 1 to 10 of 20 entries")
         } 
      );
        $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });



    });
</script>

@stop('script')
