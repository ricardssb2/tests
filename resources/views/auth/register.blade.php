@extends('layouts.auth')
@extends ('layouts.custom-new')
@section('content')

<section class="full-section 2">
  <div class="container-fluid h-custom login-area">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <div class="login-pic">
            <img src="{{url('/images/photo-register.png')}}"class="img-fluid" alt="Laptop Getting unlodked">
        </div>
        </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <div class="header-cs">
            <h1>Chipstorm Support</h1>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
        <!-- Name -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-address-card"></i>
                    </span>
                </div>

                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" required autocomplete="name" autofocus placeholder="Name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        <!-- Email -->  
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>

                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" required placeholder="Email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        <!-- Password -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>

                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="password" autofocus placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
         <!-- Comfirm Password -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>

                <input id="password-confirm" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password" autofocus placeholder="Comfirm Password" >
            </div>

          <div class="d-flex justify-content-between align-items-center">
          </div>


            <!--Login button -->
            <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" class="btn btn-dark    btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>

            
                <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account ? <a href="{{ route('login') }}"
                    class="link-danger">Login</a></p>
            </div>

        </form>
      </div>
    </div>
  </div>
</section>

@endsection
