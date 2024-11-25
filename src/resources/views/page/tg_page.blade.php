@extends('layouts.auth')

@section('content')
<div class="col-md-8">
    <div>
        <h3 class="text-white">Telegram</h3>
        <p class="text-white">Среда 2 Фев, 2021</p>
    </div>

    <form action="{{ secure_url('vk_doing') }}" method="POST">
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

        <button type="submit" name="action" value="start" class="btn btn-primary form-button mb-3">Начать</button>
    </form>
</div>
@endsection
