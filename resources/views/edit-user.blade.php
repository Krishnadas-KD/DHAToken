@extends('base')


@section('content')
<div class="content-viewport">
    <div class="row">

        <div class="col-lg-6 equel-grid">
            <div class="grid">
                <p class="grid-header">Change Password</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form action="{{ route('update_user',$user_obj->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" disabled id="name" name="name" placeholder="Name" value="{{ $user_obj->name }}" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" disabled id="email" value="{{ $user_obj->email }}" name="email" placeholder="E-Mail" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                        <label for="type">Counter Type</label>
                                        <select class="form-control" name="type" id="select_type">
                                            <option value="Counter"   {{ $user_obj->type == 'Counter' ? 'selected' : '' }}>Counter</option>
                                            <option value="Token"  {{ $user_obj->type == 'Token' ? 'selected' : '' }}>Token</option>
                                             <option value="Report"  {{ $user_obj->type == 'Report' ? 'selected' : '' }}>Report</option>
                                        </select>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control"  id="password" name="password" placeholder="Password" autocomplete="off" required>
                            </div>

                            <input type="submit" class="btn btn-sm btn-primary" value="Update">
                            <input type="reset" class="btn btn-sm btn-danger" value="Reset">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
