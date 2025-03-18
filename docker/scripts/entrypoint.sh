#!/bin/bash

# Instalar dependências do Composer
composer install

# Autoload do Composer
composer dumpautoload

# Limpar caches do Laravel
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Rodar as migrações e seeds
php artisan migrate --graceful --seed

# Instalar dependências do npm e rodar a build
# npm install
# npm run dev

# Ajustar permissões
chown -R application:application storage/ bootstrap/cache
chmod -R 755 storage/ bootstrap/cache

# Iniciar o servidor
supervisord -n

sleep 1d