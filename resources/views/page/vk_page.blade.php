@extends('layouts.auth')

@section('content')
<div class="container py-3">
    <div class="col-md-8">
        <div>
            <h3 class="text-white">Вконтакте</h3>
            <p class="text-white">Среда 2 Фев, 2021</p>
        </div>

        <form action="{{ route('vk_doing') }}" method="POST">
            @csrf

            <select name="User" id="User" class="my-select-form mb-3">
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                @endforeach
            </select>

            <select name="MessageGroup" id="MessageGroup" class="my-select-form mb-3">
                @foreach($messages as $message)
                    <option value="{{ $message->id }}">{{ $message->name_group }}</option>
                @endforeach
            </select>

            <!-- Кнопка "Начать" -->
            <button type="submit" name="action" value="start" class="btn btn-primary form-button mb-3">Начать</button>

            {{-- <!-- Кнопка "Остановить" -->
            <button type="submit" name="action" value="stop" class="w-100 btn btn-danger form-button">Остановить</button> --}}
        </form>


    </div>
</div>
@endsection
