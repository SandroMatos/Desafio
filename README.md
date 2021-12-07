Challenge - PHP

Tecnologias utilizadas

Docker
PHP 8.1
Laravel Framework 8.74.0
Mysql
Compose 


Comandos
Primeiro passo é rodar o comando para baixar as dependências:
compose install

Depois, buildar o projeto:
docker-compose build

Para subir a aplicação:
docker-compose up -d

Para rodar as migrações:
docker exec -it challenge bash -c 'php artisan migrate'

Para dar stop na aplicação:
docker-compose down



