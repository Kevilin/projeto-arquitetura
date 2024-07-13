#!/bin/bash
touch /app/storage/logs/laravel.log
chmod 777 /app/storage -R

#Aguarando o composer install rodar para gerar o key generate e o start da aplicação
while [ ! -f /app/vendor/autoload.php ]; do
    echo 'Aguardando arquivo /app/vendor/autoload.php ser criado'
    sleep 2;
done

while [ ! -d /app/database/mysql/apibcb ]; do
    echo "Aguardando install do Mysql"
    sleep 2;
done

#Para ter certeza que o mysql terminou de instalar
sleep 3;

php artisan key:generate

#Cria a tabela migration dentro do banco
php artisan migrate:install

#Cria toda a estrutura do banco workersituator e cria usuario admin
php artisan migrate

#Start dos servicos
/root/start.sh