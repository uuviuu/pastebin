<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## О проекте

Данный проект представляет мои навыки по созданию web-приложения, добавление различного функционала и REST API, а так же умение пользоваться тестами и сидерами.

Попытка реализовать что-то похожее на https://pastebin.com/.

Реализовано:
 - Создание пасты как авторизованным, так и неавторизованным пользователем, ограничение доступа к пасте и время жизни пасты
 - Авторизация по логину и паролю и через соцсети, регистрация, бан пользователя
 - Просмотр и удаление своих паст авторизованным пользователям, возможность пожаловаться на пасту
 - API и авторизация по api токену
 - К проекту добавлена админка orchid (https://github.com/orchidsoftware/platform)
 - Документация API Swagger
 - Развертывания проекта через docker-compose
 - Заполнение базы через seeders
 - Тесты API
 - Верстка сайта на библиотеке Bootstrap

## Установка

- в папку с проектами установите репозиторий: git clone https://github.com/uuviuu/pastebin.git
- sudo docker-compose up -d - установить зависимости из файла docker-compose.yml
- sudo docker exec -it pastebin_app bash 
- composer update
- composer dump-autoload
- cp .env.example .env
- cp .env .env.testing - создание файла .env.testing, после чего внести в нем правку:
   - APP_ENV=testing
- php artisan key:generate
- php artisan key:generate --env=testing
- php artisan migrate
- php artisan db:seed
- php artisan test - тестирует API: получение всех паст, создание, чтение, удаление одной пасты
- php artisan l5-swagger:generate 

Контакты: 
[почта](mailto:my.test.laravel.message@gmail.com) 
[telegram](https://t.me/uuviuu)

