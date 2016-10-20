## Installation of the application

        wget https://raw.githubusercontent.com/Viva-Resurs/Pixbo-revision/master/pixbo_install && chmod +x pixbo_install && ./pixbo_install





## Development

#### Install needed* tools

- [PHP](http://php.net/) *

- [Composer](https://getcomposer.org/download/) *

- [NodeJS & npm](https://nodejs.org/en/download/) *

- [Git](https://git-scm.com/download/win)

#### Setup project

- Get repository, example with git:


        git clone https://github.com/Viva-Resurs/Pixbo-revision.git
        cd Pixbo-revision

- Build Project


        composer update --no-scripts
        composer install
        
        php artisan migrate
        php artisan db:seed
        
        npm install
        
        gulp

#### Run Development Server


        php artisan serve


#### Troubleshooting

depending on your setup, you might need to add php to PATH

        set PATH=%PATH%;C:\php

If composer install fails, you might need to check your ``php.ini`` file if the following lines are uncommented:

        extension_dir = "ext"
        memory_limit = 512M
        upload_max_filesize = 100M
        extension=php_mbstring.dll
        extension=php_openssl.dll
        extension=php_pdo_sqlite.dll



