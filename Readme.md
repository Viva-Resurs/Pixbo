## Installation of the application

```bash
wget https://raw.githubusercontent.com/Viva-Resurs/Pixbo/master/pixbo_install && chmod +x pixbo_install && ./pixbo_install
```

## Development

#### Install needed* tools

- [PHP](http://php.net/) *

- [Composer](https://getcomposer.org/download/) *

- [NodeJS & npm](https://nodejs.org/en/download/) *

- [Git](https://git-scm.com/download/win)

#### Setup project

- Get repository, example with git:

```bash
git clone https://github.com/Viva-Resurs/Pixbo.git
cd Pixbo
```

- Build Project

```bash
composer update --no-scripts
composer install

php artisan migrate
php artisan db:seed

npm install
```

#### Run Development Server

```bash
php artisan serve
```

#### Troubleshooting

depending on your setup, you might need to add php to PATH

```bash
set PATH=%PATH%;C:\php
```

If composer install fails, you might need to check your ``php.ini`` file if the following lines are uncommented:

```ini
extension_dir = "ext"
memory_limit = 512M
upload_max_filesize = 100M
extension=php_mbstring.dll
extension=php_openssl.dll
extension=php_pdo_sqlite.dll
```
