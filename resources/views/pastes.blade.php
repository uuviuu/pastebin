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
        <div class="col-xl-8 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="mb-3">
                <a href="{{ route('pastes') }}" class="btn btn-primary"> На главную </a>
                @auth
                    <a href="{{ route('platform.pastes.create') }}" class="btn btn-primary">В панель пользователя</a>
                    <form class="hidden" action="{{ route('logout') }}" method="POST">
                        @csrf <button type="submit" class=" mt-1 btn btn-danger"> Выход</button>
                    </form>
                @else
                    <a href="{{ route('platform.login') }}" class="btn btn-primary"> Авторизация </a>
                @endauth
            </div>
            <form action="{{ route('pastes.create') }}" method="POST">
                @csrf
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title"> Отправьте пасту </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label> Паста* </label>
                            <textarea class="form-control" required name="paste" id="paste"
                                      placeholder="Введите пасту"></textarea>
                        </div>
                        <div class="form-group">
                            <label> Язык* </label>
                            <input type="text" class="form-control" required name="locale" id="locale"
                                   placeholder="Введите язык">
                        </div>
                        <label> Доступность* </label>
                        <select class="custom-select mr-sm-2" required id="access" name="access">
                            @foreach ($access as $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <label class="mt-3"> Срок действия* </label>
                        <select class="custom-select mr-sm-2" required id="expirationTime" name="expirationTime">
                            @foreach ($expirationTime as $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> Отправить</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-12 m-auto">
            <div class="mt-3 card shadow">
                <div class="card-header">
                    <h4 class="card-title"> Последние пасты </h4>

                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">Ссылка</th>
                        <th scope="col">Паста</th>
                        <th scope="col">Язык</th>
                        <th scope="col">Доступность</th>
                        <th scope="col">Срок действия</th>
                        <th scope="col">Дата создания</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lastPastes as $paste)
                        <tr>
                            <th scope="row">{{ $paste->id }}</th>
                            <td><a href="{{ route('pastes.detail', $paste->paste_hash) }}"
                                   class="badge badge-light">{{ $paste->paste_hash }}</a></td>
                            <td>{{ $paste->paste }}</td>
                            <td>{{ $paste->locale_lang }}</td>
                            <td>{{ $paste->access }}</td>
                            <td>{{ $paste->expiration_time ?? 'Неограниченно' }}</td>
                            <td>{{ $paste->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
