@extends('base')

@section('title')
    Services
@endsection('title')

@section('content')
<div class="content-viewport">
    <div class="row">
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">New Service</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('service.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="service_name">Service Name</label>
                                        <input type="text" class="form-control" name="service_name" id="service_name" placeholder="Enter Service name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="series_abbr">Service Abbr</label>
                                        <input type="text" pattern="[a-zA-Z]+" class="form-control" id="series_abbr" name="series_abbr" placeholder="Enter service abbr" autocomplete="off">
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="crt_user">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="service_name">Service Time in minute</label>
                                        <input type="number" class="form-control" name="service_time" id="service_time" placeholder="Enter Service Time" autocomplete="off">
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

        <div class="col-lg-6 equel-grid">'
            <div class="grid" >
                <p class="grid-header">Services</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="grid table-responsive">
                            <table class="table table-stretched">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Abbr</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>
                                                <p class="mb-n1 font-weight-medium">{{ $service->service_name }}</p>
                                                <small class="text-gray">{{ $service->service_time }}</small>
                                            </td>
                                            <td class="font-weight-medium">{{ $service->series_abbr }}</td>
                                            <td class="text-danger font-weight-medium">
                                                <a href="{{ route('service.edit',$service->id) }}" class="btn btn-outline btn-sm"><i class="mdi mdi-table-edit"></i></a>

                                            </td>
                                            <td class="text-danger font-weight-medium">
                                                <form action="{{ route('service.destroy',$service->id) }}" method="post">
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
                            <div class="d-felx justify-content-center mt-3">


                                {{ $services->links('pagination::bootstrap-4') }}

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
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
