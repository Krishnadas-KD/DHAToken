@extends('base')

@section('title')
    New User
@endsection('title')

@section('content')
<div class="content-viewport">
    <div class="row">

        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">New User</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('create_user') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                        <label for="type">Counter Type</label>
                                        <select class="form-control" name="type" id="select_type">
                                            <option value="Counter">Counter</option>
                                            <option value="Token">Token</option>
                                             <option value="Report">Report</option>
                                        </select>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword1">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
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
                <p class="grid-header">User List</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="grid table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Counter Type</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <p class="mb-n1 font-weight-medium">{{ $user->name }}</p>
                                                <small class="text-gray">{{ $user->email }}</small>
                                            </td>
                                            <td class="font-weight-medium">{{ $user->type }}</td>
                                            <td class="text-danger font-weight-medium">
                                                <a href="{{ route('edit_user',$user->id) }}" class="btn btn-outline btn-sm"><i class="mdi mdi-table-edit"></i></a>

                                            </td>
                                            <td class="text-danger font-weight-medium">
                                                <form action="{{ route('delete_user',$user->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline btn-sm show_confirm"><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-felx justify-content-center mt-3">
                                {{ $users->links('pagination::bootstrap-4') }}
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
