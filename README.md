<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About project

Данный проект представляет из себя API для создания, чтения, изменения и удаления одной книги, а так же вывод в формате JSON всех созданных книг

Поддерживает следующие методы и URL:
  - GET, /api/books - выводит все книги
  - POST, /api/books - добавляет книгу
  - GET, /api/books/{id} - выводит информацию об одной книге
  - PUT, /api/books/{id} - редактирует книгу
  - DELETE, /api/books/{id} - удаляет книгу
  - POST, /api/search - принимает значения title и author, выводит результат, если эти значения содержатся в значениях базы данных
  - POST, /api/filter - принимает значения title и author, выводит результат, если эти значения соответсвуют значениям в базе данных

Для упрощения развертывания проекта предусмотрен Docker

Для заполнения базы данных используйте команду php artisan migrate --seed

Для возможности тестирования данных адресов предусмотрен тест, доступный по команде php artisan test, перед его запуском необходимо установить связь с базой данных

Установка предполагает, что у вас уже установлен и настроен Docker, и присутсвует среда разработки Ubuntu-22.04

## Installation

Подготовьте рабочее простанство для развертывания проекта

- создайте папку projects в каталоге //wsl$/Ubuntu-22.04/home/имя_пользователя/projects

- в данную папку установите репозиторий командой git clone https://github.com/uuviuu/book_catalog 

Для установки данного проекта введите команды:

- docker-compose up -d - установить зависимости из файла docker-compose.yml, переименуйте поля container_name, если они уже используются, если возникнет ошибка занятости порта, то измените порты nginx и db, оставив значения после двоеточия

- sudo chmod 777 -R ./ - передача прав пользователя проекту (попросит пароль пользователя)

- docker exec -it book_catalog_app bash - войти в контейнер

- composer update - установка библиотек PHP

- composer dump-autoload - включение классов, которые используются в проекте

- cp .env.example .env - создание файла .env, после этого внести в него правки:

   -  DB_HOST=db
   -  DB_DATABASE=book_catalog
   -  DB_USERNAME=root
   -  DB_PASSWORD=root

- cp .env .env.testing - создание файла .env.testing, после чего внести в нем правку:

   - APP_ENV=testing

- php artisan key:generate - создание секретного ключа

- php artisan key:generate --env=testing

- php artisan migrate --seed - создает таблицы в БД и заполняет таблицу book_catalog значениями

- php artisan test - тестирует чтение всех данных, а также создание, чтение, редактирование, удаление одного экземпляра

Контакты: 
[почта](mailto:my.test.laravel.message@gmail.com) 
[telegram](https://t.me/uuviuu)

