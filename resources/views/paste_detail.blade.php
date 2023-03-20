<!doctype html>
<html lang="ru">

<head>
    <title> Pastebin </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
</head>

<body>

<div class="container mt-3">

    <div class="row">
        <div class="col-sm-12 col-12 m-auto">
            <div class="mb-3">
                <a href="{{ route('pastes') }}" class="btn btn-primary"> На главную </a>
                @auth
                    <a href="{{ route('platform.pastes.create') }}" class="btn btn-primary">В панель пользователя</a>
                    <form class="hidden" action="{{ route('logout') }}" method="POST">
                        @csrf <button type="submit" class=" mt-1 btn btn-danger"> Выход</button>
                    </form>
                @else
                    <a href="{{ route('platform.login') }}" class="btn btn-primary"> Авторизация </a>
                    <a href="{{ route('users.registration') }}" class="btn btn-primary"> Регистрация </a>
                @endauth
            </div>
            <div class="card shadow">
                <div class="mb-3 card-header">
                    <h4 class="card-title"> Паста № {{ $paste->id }}</h4>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" required name="paste" id="paste"
                              placeholder="{{ $paste->paste }}">{{ $paste->paste }}</textarea>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" required name="paste" id="paste"
                              placeholder="{{ $paste->paste_hash }}">{{ route('pastes.detail', $paste->paste_hash) }}</textarea>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
</body>

</html>
