cd %~dp0
git pull origin master
php artisan migrate
php artisan optimize