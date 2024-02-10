@extends('base')

@section('title')
    Auto Mail List
@endsection('title')

@section('content')
<div class="content-viewport">
    <div class="row">

        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">Add Auto Mail</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('add_auto_mail') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="name" name="email" placeholder="Name" autocomplete="off" required>
                            </div>
                           

                            <div class="form-group">
                                        <label for="type">Reports</label>
                                        <select class="form-control" name="report" id="select_type">
                                             <option value="daily-count">Daily count</option>
                                        </select>
                            </div>

                            <input type="submit" class="btn btn-sm btn-primary" value="Save">
                            <input type="reset" class="btn btn-sm btn-danger" value="Reset">
                        </form>
                    </div>
                </div>
            </div>
        </div>



        
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">Auto Mail List</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="grid table-responsive">
                             <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                    <th>Email</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($automail as $user)
                                        <tr>
                                            <td>
                                                <p class="mb-n1 font-weight-medium">{{ $user->email }}</p>
                                                <small class="text-gray">{{ $user->report }}</small>
                                            </td>
                                            <td class="text-danger font-weight-medium">
                                                <form action="{{ route('delete_auto_mail',$user->id) }}" method="post">
                                                    @csrf {{$user->id}}
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

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
