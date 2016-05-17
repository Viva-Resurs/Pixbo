### Installation of the application

 ``wget https://raw.githubusercontent.com/Viva-Resurs/Pixbo-revision/master/pixbo_install ``
 ``chmod +x pixbo_install``
 ``./pixbo_install``


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
