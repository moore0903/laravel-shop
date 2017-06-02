cd %~dp0
git pull --progress -v --no-rebase "origin"
php artisan migrate
php artisan optimize