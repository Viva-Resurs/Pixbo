### Installation of the application

* Install dependencies

        npm install
        composer install

* Setup Database

	If using sqlite (developing)
	Create empty file:
		``storage/database.sqlite``
		
        php artisan migrate
        php artisan db:seed

* Gulp

        gulp
