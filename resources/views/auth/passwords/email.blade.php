@extends('layouts.auth')
@extends ('layouts.custom-new')
@section('content')
<section class="full-section">
  <div class="container-fluid h-custom login-area">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <div class="login-pic">
            <img src="{{url('/images/photo-reset.png')}}"class="img-fluid" alt="Laptop Getting unlodked">
        </div>
        </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <div class="header-cs">
            <h1>Chipstorm Support</h1>
            <p class="text-muted">Reset Password</p>
        </div>
        @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
        <!-- Email -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                </div>

                <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email') }}">

                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <!--Login button -->
            <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" class="btn btn-dark    btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Send</button>

            
                <p class="small fw-bold mt-2 pt-1 mb-0">Remembered the password? <a href="{{ route('login') }}"
                    class="link-danger">Login</a></p>
            </div>

        </form>
      </div>
    </div>
  </div>
</section>

@endsection