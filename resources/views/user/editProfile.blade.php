@extends('layouts.lay')
@section('content')

    <div class="container">
        @include('flash.flashMessages')
        <div class="row">
            <div class="col-md-4">
                <h4>Profile information</h4>
                <p>Update your account for more information</p>
            </div>
            <div class="col-md-8">
                <form class="row g-3" action="/user/edit" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <p>Photo</p>
                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" class="rounded" alt="...">
                        @elseif($user->gender == 'male')
                        <img src="{{ asset('images/male.png') }}" class="rounded" alt="...">
                        @elseif($user->gender == 'female')
                            <img src="{{ asset('images/female.png') }}" class="rounded" alt="...">
                        @endif
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input form-control">
                        </div>
                        <label class="form-label mt-5">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">

                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                        <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" name="gender">
                            <option selected>Choose gender</option>
                            <option>male</option>
                            <option>female</option>
                        </select>
                    </div>
                    <input class="btn btn-primary col-md-8" type="submit" value="Save">
                </form>
            </div>
        </div>
    </div>



@endsection
