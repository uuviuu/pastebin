<body>
{{--<form action="{{ route('pastes.create') }}" method="POST" class="mb-md-4">--}}
{{--    @csrf--}}
{{--    <fieldset class="row g-0 mb-3">--}}
{{--        <div class="bg-white d-flex flex-column layout-wrapper rounded">--}}
{{--            <div class="mt-3 col p-0 px-3">--}}
{{--                Введите пасту--}}
{{--            </div>--}}
{{--            <fieldset class="mb-3">--}}
{{--                <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">--}}
{{--                    <div class="form-group">--}}
{{--                            <input class="form-control" id="paste" name="paste" type="text" max="255" required="required"--}}
{{--                                   title="paste" placeholder="Паста*">--}}
{{--                        <div class="mt-3">--}}
{{--                            <button type="submit" class="btn btn-success">Отправить</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </fieldset>--}}
{{--        </div>--}}
{{--    </fieldset>--}}
{{--</form>--}}
<form action="{{ route('platform.pastes.create') }}" method="get">
    @csrf
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="card shadow">
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title"> Форма обратной связи </h4>--}}
{{--                </div>--}}
                <div class="card-body">
                    <div class="form-group">
                        <label> Паста </label>
                        <input type="text" class="form-control" required name="paste" placeholder="Введите пасту">
                    </div>
{{--                    <div class="form-group">--}}
{{--                        <label> Телефон </label>--}}
{{--                        <input type="text" class="form-control" required name="number" placeholder="Введите телефон">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label> Email </label>--}}
{{--                        <input type="text" class="form-control" required name="email" placeholder="Введите Email">--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label> Сообщение </label>--}}
{{--                        <textarea class="form-control" required name="message" placeholder="Введите сообщение"></textarea>--}}
{{--                    </div>--}}
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success"> Отправить </button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
