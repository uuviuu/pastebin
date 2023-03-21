<!doctype html>
<html lang="ru">

<head>
    <title> Регистрация </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
</head>

<body>

<div class="container mt-3">

    <div class="row">
        <div class="col-xl-8 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="mb-3">
                <a href="{{ route('pastes') }}" class="btn btn-primary"> На главную </a>
                @auth
                    <a href="{{ route('platform.pastes.create') }}" class="btn btn-primary">В панель пользователя</a>
                    <form class="hidden" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class=" mt-1 btn btn-danger"> Выход</button>
                    </form>
                @else
                    <a href="{{ route('platform.login') }}" class="btn btn-primary"> Авторизация </a>
                @endauth
            </div>
            <form action="{{ route('users.create') }}" method="POST">
                @csrf
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title"> Регистрация </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="cols-sm-2 mt-1 control-label">Ваше имя</label>
                                <input type="text" class="form-control" name="name" id="name" required placeholder="Введите имя*"/>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            <label for="email" class="cols-sm-2 mt-1 control-label">Ваш email</label>
                                <input type="text" class="form-control" name="email" id="email" required placeholder="Введите email*"/>
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            <label for="password" class="cols-sm-2 mt-1 control-label">Пароль</label>
                                <input type="password" class="form-control" name="password" id="password" required placeholder="Введите пароль*"/>
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> Зарегистрироваться </button>
                    </div>
                </div>
            </form>
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
