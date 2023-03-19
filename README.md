<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## О проекте

Данный проект представляет собой API для создания, чтения, изменения и удаления одной книги, а так же вывод в формате JSON всех созданных книг

Поддерживает следующие API запросы:
- GET, /api/pastes - выводит все пасты
- POST, /api/paste - добавляет пасту
- GET, /api/paste{hash} - выводит пасту
  Содержание api post запроса на создание пасты:
  {
  "apiToken": "apiToken",
  "expirationTime": null,
  "access": "public",
  "pasteHash": "pasteHash",
  "localeLang": "RU"
  "paste": "paste"
  }
Для упрощения развертывания проекта предусмотрен Docker

Для заполнения базы предусмотрены сидеры

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

- php artisan migrate - создает таблицы в БД

- php artisan db:seed - заполняет таблицы

- php artisan test - тестирует чтение всех данных, а также создание, чтение, редактирование, удаление одного экземпляра

Контакты: 
[почта](mailto:my.test.laravel.message@gmail.com) 
[telegram](https://t.me/uuviuu)

