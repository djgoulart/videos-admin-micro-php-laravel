
# Laravel 9.x - Videos Catalog Admin

## Rodar o Projeto

Clone Repositório
```sh
git clone https://github.com/djgoulart/videos-admin-micro-php-laravel videos-admin
```

```sh
cd videos-admin/
```

Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="Video Admin"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=code_micro_videos
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acesse o container app
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```


Acesse o projeto
[http://localhost:8000](http://localhost:8000)

<br />

## Rodar os Testes

Acesse o container app
```sh
docker-compose exec app bash
```

```sh
php artisan test
```
ou

```sh
./vendor/bin/phpunit
```
