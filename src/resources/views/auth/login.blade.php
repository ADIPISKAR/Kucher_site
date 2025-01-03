@extends('layouts.guest')

@section('content')
    <div class="row justify-content-center h-100 align-content-center flex-column">
        <div class="col-md-8 col-md-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4">

            <div class="d-flex flex-column align-items-start mb-3">
                <p class="text-center Main-Text">Вход в SendDive</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <p class="Second-text mb-1">Логин или емейл</p>
                    <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">

                    <div class="d-flex justify-content-between">
                        <p class="Second-text mb-1">Пароль</p>
                        <p class="Second-link-text mb-1">Восстановить доступ</p>
                    </div>

                    <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="mb-3 d-flex text-white  justify-content-between">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" id="custom-checkbox" class="custom-checkbox">
                        <label for="custom-checkbox" class="custom-label">Запомнить меня</label>
                    </div>

                    <a class="Second-Text-Small">Забыл пароль?</a>
                </div>

                <button class="w-100 btn btn-primary form-button">Войти в панель управления</button>
            </form>

        </div>

        <div class="col-md-8 col-md-8 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <form action="{{ route('register') }}" method="POST">
                <div class="d-flex flex-row align-items-baseline">
                    <div class="line"></div>
                    <p class="Second-text m-0 mx-2">или</p>
                    <div class="line"></div>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary form-button-second mt-3">Регистрация</button>

                </div>
            </form>
        </div>
    </div>
@endsection
