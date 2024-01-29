@extends('base')

@section('title')
    Counters


@endsection('title')

@section('content')
<div class="content-viewport">
    <div class="row">
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">New Counter</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('counter.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="counter_name">Counter Name</label>
                                        <input type="text" class="form-control" name="counter_name" id="counter_name" placeholder="Enter counter name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="counter_number">Counter Number</label>
                                        <input type="number" class="form-control" name="counter_number" id="counter_number" placeholder="Enter counter number" autocomplete="off">
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="crt_user">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="counter_section">Counter Section</label>
                                        <select class="form-control" name="counter_section" id="select_counter_type">
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 equel-grid">
            <div class="grid" >
                <p class="grid-header" id="tx">Counters</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="grid table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counters as $counter)
                                        <tr>
                                            <td>
                                                <p class="mb-n1 font-weight-medium">{{ $counter->counter_name }}</p>
                                                <small class="text-gray">{{ $counter->counter_section }}</small>
                                            </td>
                                            <td class="font-weight-medium">{{ $counter->counter_number }}</td>
                                            <td class="text-danger font-weight-medium">
                                                {{-- <div class="badge badge-{{ ['success','danger'] [$loop->index % 2]}}">-1.39%</div> --}}
                                                {{-- <div class="badge badge-primary"><i class="mdi mdi-table-edit"></i></div> --}}
                                                <a href="{{ route('counter.edit',$counter->id) }}" class="btn btn-outline btn-sm"><i class="mdi mdi-table-edit"></i></a>

                                            </td>
                                            <td class="text-danger font-weight-medium">
                                                <form action="{{ route('counter.destroy',$counter->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline btn-sm show_confirm"><i class="mdi mdi-delete"></i></button>
                                                </form>
                                                {{-- <a href="{{ route('delete_user',$user->id) }}" class="btn btn-outline btn-sm"><i class="mdi mdi-delete-sweep"></i></a> --}}
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
