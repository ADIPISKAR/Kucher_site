@extends('layouts.auth')

@section('content')
<div class="container py-3">
    <div class="col-md-8">
        <form action="{{ route('add_message') }}" method="POST">
            @csrf

            <div class="mb-3">
                <p class="text-white">Введите название группы</p>
                <input placeholder="Название группы" class="form-input" name="name_group" autofocus>
            </div>

            <div class="mb-3">
                <p class="text-white">Введите сообщение</p>
                <input placeholder="Введите сообщение" class="form-input" name="message_1" autofocus>
            </div>

            <div class="mb-3">
                <p class="text-white">Введите сообщение</p>
                <input placeholder="Введите сообщение" class="form-input" name="message_2">
            </div>

            <div class="mb-3">
                <p class="text-white">Введите сообщение</p>
                <input placeholder="Введите сообщение" class="form-input" name="message_3">
            </div>

            <div class="mb-3">
                <p class="text-white">Введите сообщение</p>
                <input placeholder="Введите сообщение" class="form-input" name="message_4">
            </div>

            <button class="w-100 btn btn-primary form-button">Создать</button>
        </form>
    </div>
</div>
@endsection
