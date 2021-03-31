# Hwackker

Build the project:

```bash
composer install
```

Migrate the database:

```bash
touch hwackker.sqlite
php artisan migrate --seed
```

Run the PHP server:

```
php artisan serve
```

Associer les path public et storage:

```
php artisan storage:link
```

