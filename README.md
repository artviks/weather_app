This is a simple web app to fetch weather and location data from public apis and display data in json.

PHP 8.0 required, symfony binary

To use this app:

```
cd projects/
git clone ...
cd my-project/
composer install
```

Add valid api keys in .env for:
<li>api.ipstack.com
<li>api.openweathermap.org</li>

Set up your DB in .env and then run:

```
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
symfony server:start
```

 And in browser you should see weather and location data in json.
 Else, if api key is wrong, some error will pop up in symfony default dev style containing message of what went wrong.