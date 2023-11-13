## Backend сервиса  заметок (TO-DO list)

Этот проект реализован с помощью PHP 8.1 , фреймворка Laravel, PostgreSql, Php-fpm, Nginx и RabbitMq.

## Документация к API

API сервиса заметок документировано с помощью Swagger. 
Для просмотра и использования документации, запустите сервер разработки и перейдите по адресу http://localhost/api/docs.

### Проект можно собрать в Docker-контейнере для удобства развертывания. Для этого:

1. Установите Docker на свое устройство.
2. Склонируйте репозиторий и перейдите в каталог проекта.
3. Скопируйте файл .env.example в .env и настройте переменные окружения.
4. Откройте файл docker-compose.yml и укажите необходимые параметры.
5. Запустите проект с помощью команды:

```bash
docker-compose build
```

Запустить контейнеры:

```bash
docker-compose up -d
```

Проверить запущенные контейнеры

```bash
docker-compose ps -a
```

#### Для установки необходимых библиотек и запуска Consumer:

Зайти в контейнер php-fpm

```bash
docker-compose exec php-fpm bash
```

Установить необходимые библиотеки

```bash
composer install
```

Запустить миграции

```bash
php artisan migrate
```

Запустить сидеры для заполнения базы данных тестовыми данными:

```bash
php artisan db:seed
```

Запустить "Consumer"

```bash
php artisan queue:work --queue=admin
```
