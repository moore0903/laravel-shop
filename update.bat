cd %~dp0
git pull
php artisan migrate
php artisan optimize