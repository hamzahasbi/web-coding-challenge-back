#!/usr/bin/env bash
mkdir config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:webcodingchallengeapi
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:webcodingchallengeapi
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load