<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## О проекте

Для упрощения развертывания проекта предусмотрен Docker

Для заполнения базы данных используйте команду php artisan migrate --seed

Для возможности тестирования данных адресов предусмотрен тест, доступный по команде php artisan test, перед его запуском необходимо установить связь с базой данных

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

- php artisan migrate --seed - создает таблицы в БД и заполняет таблицу pastes значениями

- php artisan test - тестирует чтение всех данных, а также создание, чтение, редактирование, удаление одного экземпляра

Контакты: 
[почта](mailto:my.test.laravel.message@gmail.com) 
[telegram](https://t.me/uuviuu)

