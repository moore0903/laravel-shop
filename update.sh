#!/bin/sh 
cd `dirname $0`
git pull
rm -fr public/static/*.htm
rm -fr public/static/article/*
rm -fr public/static/special/*
php artisan migrate
php artisan optimize
chmod -R 777 public/imgs
