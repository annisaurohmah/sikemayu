@extends('layouts.master-blank')

@section('content')
<!-- Log on to codeastro.com for more projects! -->
<div class="wrapper-page">
    <div class="card overflow-hidden account-card mx-3">
        <div class="bg-secondary p-4 text-white text-center position-relative">
            <h4 class="font-20 m-b-5">Sistem Pelaporan Kegiatan PKK Desa Margaluyu</h4>
            <p class="text-white-50 mb-4"></p>
            <a href="" class="logo logo-admin">
                <i class='fas fa-home' style='font-size:36px;color:white'></i>
            </a>
        </div>
        <div class="account-card-content">
            <form class="form-horizontal m-t-30" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="Username" class="col-form-label ">{{ __('Username') }}</label>

                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="col-form-label ">{{ __('Password') }}</label>


                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group row m-t-20">
                    <div class=" col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-success w-md waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>


            </form>
        </div>
    </div>


</div>
<!-- Log on to codeastro.com for more projects! -->
<!-- end wrapper-page -->
@endsection

@section('script')
@endsection