Для установки приложения необходимо выполнить следующие шаги:

1. Убедитесь, что Ваш сервер удовлетворяет требованиям [laravel server requirements](https://laravel.com/docs/7.x/installation#server-requirements);

1. Создайте базу данных;

1. На основе файла .env.example создайте .env и добавьте в него значения:

    1. учетные данные подключения к бд;
    1. логин, email и пароль пользователя по-умолчанию;
    
1. Выполнить миграцию и посев данных:
    
```
php artisan migrate:refresh --seed
```
