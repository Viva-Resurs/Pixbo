### Installation of the application

* Install

        npm install
        composer update --no-scripts
        
* Setup Database

	If using sqlite (developing)
	Create empty file:
	``storage/database.sqlite``
	
        php artisan migrate
        php artisan db:seed
        
* Finish installation

	``composer install``

* Gulp

        gulp
