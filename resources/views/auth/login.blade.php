@extends ('layouts.custom-new')
@extends('layouts.auth')
@section('content')

<section class="full-section">
  <div class="container-fluid h-custom login-area">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <div class="login-pic">
            <img src="{{url('/images/photo-login.png')}}"class="img-fluid" alt="Laptop Getting unlodked">
        </div>
        </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <div class="header-cs">
            <h1>Chipstorm Support</h1>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
        <!-- Email -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                </div>

                <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">

                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

        <!-- Password -->  
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>

                <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">

                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
              <label class="form-check-label white" for="form2Example3">
                Remember me!
              </label>  
            </div>
            <a href="{{ route('password.request') }}" class="white" >Forgot password?</a>
          </div>


            <!--Login button -->
            <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" class="btn btn-dark    btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>

            
                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}"
                    class="link-danger">Register</a></p>
            </div>

        </form>
      </div>
    </div>
  </div>
</section>
@endsection