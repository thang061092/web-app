@extends('admin.dashboard.index')
@section('title','Profile')
@section('content')
    <div class="card">
        <h5 class="card-header">Profile</h5>
        <div class="card-body">
            <form method="post" action="{{route('updateProfile',$user->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <img class="pb-2" src="@if($user->image) {{$user->image}} @else {{asset('img/1_ctwzukbetpa87r_nnymqjq-533x800-2.jpeg')}} @endif" width="150px" height="150px">
                    <input type="file" class="form-control" name="avatar">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="name" class="form-control" value="{{$user->name}}" name="name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" value="{{$user->email}}" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="tel" class="form-control" value="{{$user->phone}}" disabled>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
