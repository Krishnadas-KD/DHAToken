@extends('base')


@section('content')
<div class="content-viewport">
    <div class="row">
        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">New Counter</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('counter.update',$counter->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="counter_name">Counter Name</label>
                                        <input type="text" value="{{ $counter->counter_name }}" class="form-control" name="counter_name" id="counter_name" placeholder="Enter counter name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="counter_number">Counter Number</label>
                                        <input type="number" value="{{ $counter->counter_number }}" class="form-control" name="counter_number" id="counter_number" placeholder="Enter counter number" autocomplete="off">
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="crt_user">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="counter_section">Counter Section</label>
                                        
                                        <select class="form-control" name="counter_section" id="select_counter_type">
                                            <option value="MALE"  {{ $counter->counter_section == 'MALE' ? 'selected' : '' }}>MALE</option>
                                            <option value="FEMALE"  {{ $counter->counter_section == 'FEMALE' ? 'selected' : '' }} >FEMALE</option>
                                        </select>
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
