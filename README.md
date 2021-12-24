1. you have to install composer.

2. composer update

3. php artisan migrate

4. php artisan db:seed
    (or individually)

    php artisan db:seed --class=PermissionsTableSeeder

    php artisan db:seed --class=UserSeeder

    php artisan db:seed --class=CompaniesTableSeeder

    php artisan db:seed --class=CitiesTableSeeder

    php artisan db:seed --class=RouteKnownTableSeeder

    php artisan db:seed --class=CustomerGroupTableSeeder

    php artisan db:seed --class=CustomerTableSeeder

    php artisan db:seed --class=StockBrokerTableSeeder

    php artisan db:seed --class=NewsSeeder

    php artisan db:seed --class=ConsultingSeeder

    php artisan db:seed --class=ContentHomeSeeder

    php artisan db:seed --class=VisitorReviewSeeder


    % After creating or removing your seeders, don't forget to run the following command:

    composer dump-autoload

5. php artisan serve --port=8080
