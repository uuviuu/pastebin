<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## О проекте

Данный проект представляет мои навыки по созданию приложения, добавление различного функционала и REST API, а так же умение пользоваться тестами и сидерами.

Для создания админки была использована библиотека https://github.com/orchidsoftware/platform

Для развертывания проекта предусмотрен docker-compose

Для заполнения базы предусмотрены сидеры

Для возможности тестирования API предусмотрены тесты

## Установка

- в папку с проектами установите репозиторий: git clone https://github.com/uuviuu/pastebin.git

- sudo docker-compose up -d - установить зависимости из файла docker-compose.yml

- sudo docker exec -it pastebin_app bash - войти в контейнер

- composer update - установка библиотек PHP

- composer dump-autoload - включение классов, которые используются в проекте

- cp .env.example .env - создание файла .env

- cp .env .env.testing - создание файла .env.testing, после чего внести в нем правку:

   - APP_ENV=testing

- php artisan key:generate - создание секретного ключа

- php artisan key:generate --env=testing

- php artisan migrate - создает таблицы в БД

- php artisan db:seed - заполняет таблицы

- php artisan test - тестирует чтение всех данных, а также создание, чтение, удаление одной пасты через API

Контакты: 
[почта](mailto:my.test.laravel.message@gmail.com) 
[telegram](https://t.me/uuviuu)

