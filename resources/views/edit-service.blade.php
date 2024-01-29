@extends('base')


@section('content')
<div class="content-viewport">
    <div class="row">
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">Update Service</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('service.update',$service->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="service_name">Service Name</label>
                                        <input type="text" class="form-control" value="{{ $service->service_name }}" name="service_name" id="service_name" placeholder="Enter Service name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputEmail1">Service Abbr</label>
                                        <input type="text" class="form-control" value="{{ $service->series_abbr }}" id="series_abbr" name="series_abbr" placeholder="Enter service abbr" autocomplete="off">
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="crt_user">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="service_name">Service Time</label>
                                        <input type="text" class="form-control" value="{{ $service->service_time }}" name="service_time" id="service_time" placeholder="Enter Service name" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            {{-- <button type="reset" class="btn btn-sm btn-danger">Reset</button> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop
