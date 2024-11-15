
<DOCTYPE html>
    <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content="width=device-width, initial-scale=1.0">

            <title> @yield('title') </title>

            <link href="css/MyStylee.css" rel="stylesheet" type="text/css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        </head>

        <body>
            <div class="d-flex">
                <div class="MainLeftMenu">
                    <div class="mb-5 text-center">
                        <a >
                            <img class="max-c" src="images/Logo.png" alt="VK">
                        </a>
                    </div>

                    {{-- Блок ВК --}}
                    <div class="mb-5 text-center">
                        <a href="{{route('vk_page')}}">
                            <img class="max-c" src="images/vk.png" alt="VK">
                        </a>
                    </div>

                    {{-- Блок TG --}}
                    <div class="mb-5 text-center">
                        <a href="{{ route('tg_page') }}">
                            <img class="max-c" src="images/tg.png" alt="TG">
                        </a>
                    </div>

                    {{-- Блок настроек --}}
                    <div class="mb-5 text-center">
                        <a href="{{route('setting_page')}}">
                            <img class="max-c" src="images/setting.png" alt="VK">
                        </a>
                    </div>

                    {{-- Блок выхода --}}
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <div class="text-center">
                            <button type="submit" class="border-0 bg-transparent">
                                <img class="max-c" src="images/Logout.png" alt="Logout">
                            </button>
                        </div>
                    </form>
                </div>

                <div class="main-right-block w-100 mx-4 my-4">
                    <div class="row d-flex w-100 h-100">
                        @yield('content')
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </body>
    </html>
