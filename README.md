Парсер данных
Этот проект представляет собой консольную команду для Laravel, которая парсит XML файл с данными, обновляет, добавляет или удаляет записи в базу данных.
PHP - 8.1
Laravel - 10.0

1) git clone <url-репозитория>
2) cd <название-папки>
3) composer install
4) Создайте файл .env на основе .env.example и установите настройки подключения к базе данных.
    cp .env.example .env
5) php artisan key:generate
6) php artisan migrate
7) php artisan parse:cars {путь_к_XML_файлу}
