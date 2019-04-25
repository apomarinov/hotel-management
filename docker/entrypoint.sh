#!/usr/bin/env bash

if [[ -n "${BUILD}" ]]; then
  cd /var/www/html
  composer install
fi

if [[ -n "${INITIAL}" ]]; then
    cd /var/www/html

    if [[ -f .env ]]; then
        export $(cat .env | xargs)

        if [[ -z "${APP_KEY}" ]]; then
            composer install
            php artisan key:generate
            php artisan config:cache

            if [[ -n "${SEED}" ]]; then
                php artisan migrate:fresh --seeder=AppSeeder
            else
                php artisan migrate:fresh
            fi
        fi
    fi
fi

apache2ctl -D FOREGROUND
