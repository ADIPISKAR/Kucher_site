@extends('layouts.guest')

@section('content')
    <div class="row justify-content-center h-100 align-content-center flex-column">
        <div class="col-md-8 col-md-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4">

            <div class="d-flex flex-column align-items-start mb-3">
                <p class="text-center Main-Text">Регистрация в SendDive</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <p class="Second-text mb-1">ФИО</p>
                    <input id="FIO" type="text" class="form-input" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <p class="Second-text mb-1">Емейл</p>
                    <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <p class="Second-text mb-1">Телефон</p>
                    <input id="tel" type="tel" class="form-input" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="8 (___) ___-__-__" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <button class="w-100 btn btn-primary form-button">Зарегистрироваться</button>
            </form>

        </div>

        <div class="col-md-8 col-md-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="d-flex flex-row align-items-baseline">
                    <div class="line"></div>
                    <p class="Second-text m-0 mx-2">или</p>
                    <div class="line"></div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <p class="Second-text m-0 mx-2">Уже есть аккаунт?<a href="/login" class="Second-text-link mx-1">Войдите</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection



{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
