## Installation of the application

        wget https://raw.githubusercontent.com/Viva-Resurs/Pixbo-revision/master/pixbo_install && chmod +x pixbo_install && ./pixbo_install





## Development

#### Install needed tools

- [PHP](http://php.net/)

unzip and set Path

        set PATH=%PATH%;C:\php

Create a ``php.ini`` file from ``php.ini-development`` and uncomment following lines:

        extension_dir = "ext"
        memory_limit = 512M
        upload_max_filesize = 100M
        extension=php_mbstring.dll
        extension=php_openssl.dll
        extension=php_pdo_sqlite.dll

- [Visual Studio 2013 Community](https://www.visualstudio.com/post-download-vs?sku=community&clcid=0x409)

- [MS Build Tools 2013](https://www.microsoft.com/en-us/download/confirmation.aspx?id=40760)

- [Python 2.7.11](https://www.python.org/downloads/)

- [Ruby](https://www.ruby-lang.org/en/downloads/)

- [Composer](https://getcomposer.org/download/)

- [NodeJS & npm](https://nodejs.org/en/download/)

- [Git](https://git-scm.com/download/win)

#### Setup project

- Get repository:


        git clone https://github.com/Viva-Resurs/Pixbo-revision.git
        cd Pixbo-revision

- Create Database (empty file: ``storage/database.sqlite``)

- Build Project


        npm config set msvs_version 2013 --global
        npm install
        composer update --no-scripts
        composer install
        php artisan migrate
        php artisan db:seed
        gulp

#### Run Development Server


        php artisan serve
