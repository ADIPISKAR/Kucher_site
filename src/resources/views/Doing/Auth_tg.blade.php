@extends('layouts.auth')

@section('content')
<div class="container py-3">
    <div class="col-md-8">
        <form action="{{secure_url('Nfsdsdfsdf') }}" method="POST">
            @csrf

            <p>Привет мир!</p>
            <!-- <div class="mb-3">
                <p class="text-white">Введите имя аккаунта</p>
                <input placeholder="Имя аккаунта" class="form-input" name="name" autofocus>
            </div>

            <div class="mb-3">
                <p class="text-white">Введите API HASH</p>
                <input placeholder="API hash" class="form-input" name="Hash">
            </div>

            <button class="w-100 btn btn-primary form-button">Создать</button> -->
        </form>
    </div>
</div>
@endsection
