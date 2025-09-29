Introduction
============

Вполнено на PHP 8.4.1, Apache/2.4.63, Node-22.19.0, MySQL 8.4

В .env параметр для изменения количества записей "POSTS_COUNT" и конфиг для подключения базы данных

база данных в /database


Сomposer
```php
composer install
```
Webpack
```php
npm i

npm run build
```
Есть поддержка сонсольных команд [Doctrine ORM](https://www.doctrine-project.org/projects/doctrine-orm/en/3.5/reference/tools.html)
```php
php bin/doctrine orm:schema-tool:update --force
```

