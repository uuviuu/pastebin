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
                    <a href="{{ route('users.registration') }}" class="btn btn-primary"> Регистрация </a>
                    <a href="{{ route('auth.social', 'google')  }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                        </svg>
                    </a>
                    <a href="{{ route('auth.social', 'github')  }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                        </svg>
                    </a>
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
                            @error('paste')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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
                            <td>{{ $paste->lang }}</td>
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
