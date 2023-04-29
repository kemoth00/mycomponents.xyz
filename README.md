# mycomponents

## Init project after clone:
* copy **.env.example** and rename it to **.env**
* `composer install`
* `npm install`
* `php artisan key:generate`

### If database needed:
* create local database
* set the following **.env** variables:
    * DB_DATABASE
    * DB_USERNAME
    * DB_PASSWORD

* `php artisan migrate:fresh`


## Run project:

* `npm run dev`
* `php artisan serve`
