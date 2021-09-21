#!/usr/bin/bash

# abort on errors
set -e

# build
rm -rf dist
mkdir dist

shopt -s extglob
shopt -s dotglob
cp -r !(dist|deploy.sh) ./dist

# navigate into the build output directory
cd dist

rm -rf .git

shopt -u dotglob

php artisan db:wipe
php artisan migrate:fresh

php artisan test

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

composer dump-autoload

php artisan config:cache

git init
git add -A
git commit -m 'deploy'

git push -f git@github.com:fatexii/sondi-api.git master:deployment

cd -
