@extends('layouts.auth')

@section('content')
<div class="container py-3">
    <div class="col-md-8">
        <form action="{{secure_url('register_number')}}" method="POST">
            @csrf

            <div class="mb-3">
                <p class="text-white">Введите номер телефона</p>
                <input placeholder="Имя аккаунта" class="form-input" name="phone" autofocus>
            </div>

            <button class="w-100 btn btn-primary form-button">Отправить</button>
        </form>
    </div>
</div>
@endsection
