# Installation

* [PHP](http://php.net)
* [Python 2.7.11](https://www.python.org/downloads)
* [Ruby](https://www.ruby-lang.org/en/downloads)
* [NodeJS](https://nodejs.org/en/download)
* [Composer](https://getcomposer.org/download)

Windows:
* [Visual Studio 2013 Community](https://www.visualstudio.com/post-download-vs?sku=community&clcid=0x409)
* [Microsoft Build Tools 2013](http://www.microsoft.com/en-us/download/details.aspx?id=40760)

run cmd to set global flag to use the 2013 version:

    npm config set msvs_version 2013 --global

After this everything should be back to normal and your npm install / node-gyp rebuild will work.

If not, try:

    npm install npm@3.5.1 -g

### Installation of the application

* Install dependencies

        npm install
        composer install

* Setup Database

        php artisan migrate
        php artisan db:seed

* Gulp

        gulp


Setup the crontask:

    * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
