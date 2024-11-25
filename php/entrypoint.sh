#!/bin/bash

echo "Running entrypoint.sh script"

# Criar diretórios necessários se não existirem
echo "Creating storage and cache directories..."
mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar permissões para o Laravel
echo "Setting permissions for Laravel..."
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "Entrypoint script complete. Executing command..."
exec "$@"
