@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center h-100 align-content-center">
        <div class="col-md-4">

            <div class="d-flex flex-column align-items-center mb-3">
                <h1 class="text-center text-white bold-text">Мы обновились!</h1>
                <p class="text-center Second-Text">Теперь работать с нами стало ещё удобнее и современнее!</p>
            </div>

                <form action="{{ secure_url('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <input placeholder="Почта" id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input placeholder="Пароль" id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="mb-5 d-flex text-white  justify-content-between">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="custom-checkbox" class="custom-checkbox">
                            <label for="custom-checkbox" class="custom-label">Запомнить меня</label>
                        </div>

                        <a class="Second-Text-Small">Забыл пароль?</a>
                    </div>

                    <button class="w-100 btn btn-primary form-button">Войти</button>
                </form>

        </div>
    </div>
</div>
@endsection