@extends('layouts.auth')

@section('content')
<div class="container py-3">
    <div class="col-md-8">
        <h2 class="text-white">Настройки</h2>

        <div class='BlockSetting mt-4'>

            {{-- Блок текста --}}
            <div>
                <h3 class="text-white">Настройки</h3>
                <p class="text-white">Среда 2 Фев, 2021</p>
            </div>

            {{-- Линия --}}
            <div class="mb-3" style="border-top: 1px solid white; width: 100%;"></div>

            {{-- Блока аккаунтов --}}
            <div class="mb-5">
                <h4 class="text-white">Аккаунты</h4>

                @foreach ($accounts as $account)
                <div class="list-my-group">
                    <div class="d-flex mt-2" style="width: 80%;">
                        <p>{{ $account->name }}</p>
                        <p style="overflow: hidden; width: 450px; text-overflow: ellipsis;">{{ $account->Hash }}</p>
                    </div>

                    <form action="{{ secure_url('destroy_user', $account->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-primary button-delete">Удалить</button>
                    </form>

                </div>
                @endforeach

                <form action="{{ secure_url('Add_list')}}" method="GET">
                    <button class="btn btn-primary form-button-add">Добавить аккаунт</button>
                </form>
            </div>

            <div>
                <h4 class="text-white">Сообщения</h4>

                @foreach ($messages as $message)
                <div class="list-my-group">
                    <p>{{ $message->name_group }}</p>

                    <form action="{{secure_url('message_destroy', $message->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-primary button-delete">Удалить</button>
                    </form>

                </div>
                @endforeach

                <form action="{{ secure_url('add_message_route') }}" method="GET">
                    <button class="btn btn-primary form-button-add">Добавить группу сообщений</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
