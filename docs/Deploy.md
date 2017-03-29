# Deploy (through SSH)

## Install Pixbo
```bash
wget https://raw.githubusercontent.com/Viva-Resurs/Pixbo/master/pixbo_install && chmod +x pixbo_install && ./pixbo_install
```

## Update Pixbo
```bash
cd Pixbo
git pull

# New migrations?
php artisan migrate

# Changes in UI?
npm run build

# Changes in PixboPlayer?
npm run build-pixboplayer

# New php dependencies? (Note: Backup database!)
composer install
```
