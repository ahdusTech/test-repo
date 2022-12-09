@extends('layouts.web.app')

@section('content')

<style>
    .needs-validation {
        color: #555;
        display: block;
        border: 1px solid rgb(186,186,186);
        border-radius: 5px;
        /* width: 100%; */
        margin: 0 auto;
        height: 31px;
    }
</style>
  <div class="row" style="height: 100%;">
             <div class="col-md-4 mx-auto">
                <div class="myform form mt-2 ">
                <h1 class="text-center" style="font-weight: 400;margin-bottom: 5%;text-align: center;font-size: 21px;">Log in</h1>


                        <form method="POST" class="needs-validation" action="{{ route('customer.login') }}">
                            @csrf
                            <div>


                            <div class="form-group">
                                <input autofocus type="email" value="{{ old('email') }}"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror" placeholder="{{__('auth.customer_registration_form_input_email')}}" style="font-size: 20px">

                                @error('email')
                                <span class="invalid-feedback error" role="alert">
                                    <strong>{{ $message }}</strong>
                                   {{-- <strong>Geben Sie Ihre E-Mail-Adresse ein.</strong>--}}
                                </span>
                                @enderror
                              </div>
                              <div class="form-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="{{__('auth.customer_registration_form_input_password')}}" style="font-size: 20px">

                                @error('password')
                                    <span class="error invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>


                                <div class="form-group" style="display: flex">
                                <div class="col-6">
                                    <div class="icheck-primary">
                                        <span>
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        </span>
                                        <label for="remember" style="color: #171819; margin-left: 5px;font-size: 18px;">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    @if (Route::has('customer.password.reset.request.form'))
                                        <a href="{{ route('customer.password.reset.request.form') }}" style="font-size: 16px;">
                                            Forgotten password?
                                        </a>
                                    @endif
                                </div>
                            </div>


                              <div class="col-12">
                              <button type="submit" class="btn btn-secondary btn-sm" style="width: 100px;background-color:#048BA8;font-size: 19px;">Log in</button>

                            </div>
                        </div>
                        <br>
                        <div class="text-center" style="font-size: 17px;">
                            Don't have a customer account yet?
                            <a href="{{route('customer.register_form')}}">
                                Create account
                            </a>
                        </div>
                   </form>




                </div>

             </div>


          </div>


@endsection



