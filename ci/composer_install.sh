apt-get update
apt-get install zip unzip

echo "installing composer..."
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"

echo "installing auth file..."
cat $MAGENTO_AUTH > auth.json

echo "installing dependencies..."
composer install --no-dev

echo "done."
