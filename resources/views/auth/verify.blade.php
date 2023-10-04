@extends('layouts.app')

@section('content')

<section class="my_account_area pt--80 pb--55 bg--white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <div class="my__account__wrapper">
                    <h3 class="account__title text-center">{{ __('Verify Your Email Address') }}</h3>
                    
                    @if (session('resent'))
                        <div class="alert alert-success mt-2" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <form  class="white-shadow-form shadow-1" method="POST" action="{{ route('verification.resend') }}">
                        @csrf       
                        <div class="account__form">
                            <div class="input__box">                                
                                {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},                                
                            </div>
                            <div class="form__btn">                            
                                <button>{{ __('click here to request another') }}</button>                            
                            </div>
                        </div>                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
