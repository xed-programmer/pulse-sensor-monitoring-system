@extends('layouts.app')

@section('header')
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            {{-- <h2>Inner Page</h2> --}}
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('user.index') }}">User</a></li>
                <li>Profile</li>
            </ol>
        </div>

    </div>
</section>
@endsection

@section('content')
<section id="contact" class="contact">

    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Profile</h2>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="100">

            <div class="col-lg-12">
                <form action="{{ route('profile.update.user', $user) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control p-2 m-2" id="name" value="{{ $user->name }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control p-2 m-2" name="email" id="email" value="{{ $user->email }}"
                            disabled>
                    </div>
                    <div class="text-center"><input type="submit" class="btn btn-primary" value="Update"/></div>
                </form>

                <form action="{{ route('profile.update.password', $user) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" class="form-control p-2 m-2" id="current_password" placeholder="Current Password"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" class="form-control p-2 m-2 @error('password') is-invalid @enderror" id="password" placeholder="New Password"
                            required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control p-2 m-2" id="password_confirmation" placeholder="Confirm Password"
                            required>
                    </div>
                    <div class="text-center"><input type="submit" class="btn btn-primary" value="Update"/></div>
                </form>
            </div>

        </div>

    </div>
</section>
@endsection