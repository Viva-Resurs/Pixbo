# Installation

- Install ruby
- Install NodeJS
- Install Composer

###For windows:
   Microsoft Build Tools 2013 :
    http://www.microsoft.com/en-us/download/details.aspx?id=40760

    run cmd to set global flag to use the 2013 version:
    npm config set msvs_version 2013 --global

   After this everything should be back to normal and your npm install / node-gyp rebuild will work


### Installation of the application
    npm install
    composer install
    php artisan migrate
    php artisan db:seed
    gulp


Setup the crontask:

    * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1