#!/usr/bin/env bash

# used when doploying
if [[ -n "${BUILD}" ]]; then
  cd /var/www/html
  composer install
  npm install
  npm run prod
fi

# when running for first time locally
if [[ -n "${INITIAL}" ]]; then
    cd /var/www/html

    if [[ -f .env ]]; then
        export $(cat .env | xargs)

        if [[ -z "${APP_KEY}" ]]; then
            composer install
            npm install
            npm run prod
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

# if we are not deploying, start apache
if [[ -z "${BUILD}" ]]; then
  apache2ctl -D FOREGROUND
fi
