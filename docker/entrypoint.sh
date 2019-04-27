#!/usr/bin/env bash

# colors
BLUE='\033[1;36m'
GREEN='\033[1;32m'
NC='\033[0m'

# used when doploying
if [[ -n "${BUILD}" ]]; then
  printf "${GREEN} BUILD ${NC}\n"
  cd /var/www/html

  printf "${BLUE} COMPOSER ${NC}\n"
  composer install

  printf "${BLUE} NPM INSTALL ${NC}\n"
  npm install

  printf "${BLUE} NPM BUILD ${NC}\n"
  # TODO: If using 'prod' EC2 instance hangs on "92% chunk asset optimization"
  npm run dev
fi

# when running for first time locally
if [[ -n "${INITIAL}" ]]; then
    cd /var/www/html

    if [[ -f .env ]]; then
        export $(cat .env | xargs)

        if [[ -z "${APP_KEY}" ]]; then
            printf "${GREEN} INITIAL ${NC}\n"

            printf "${BLUE} COMPOSER ${NC}\n"
            composer install

            printf "${BLUE} NPM INSTALL ${NC}\n"
            npm install

            printf "${BLUE} NPM BUILD ${NC}\n"
            npm run prod

            printf "${BLUE} KEYGEN ${NC}\n"
            php artisan key:generate

            if [[ -n "${SEED}" ]]; then
                printf "${BLUE} MIGRATE AND SEED ${NC}\n"
                php artisan migrate:fresh --seeder=AppSeeder
            else
                printf "${BLUE} MIGRATE ${NC}\n"
                php artisan migrate:fresh
            fi

            printf "${BLUE} CACHE ${NC}\n"
            php artisan config:cache
        fi
    fi
fi

# if we are not deploying, start apache
if [[ -z "${BUILD}" ]]; then
    printf "${BLUE} DONE ${NC}\n"
    apache2ctl -D FOREGROUND
    php artisan config:cache
fi
