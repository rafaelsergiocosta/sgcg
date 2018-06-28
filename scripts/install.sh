#!/bin/bash

cd /var/www/html

# Install Backend dependencies
if [ ! -d "vendor/" ]; then
    if [ ! -f "composer.phar" ]; then
        wget https://getcomposer.org/download/1.6.5/composer.phar
    fi

    php composer.phar install
fi

# Install Frontend dependencies
if [ ! -d "public/vendor/" ]; then
    bower install --allow-root
fi

# Remove composer.phar
rm composer.phar

# Run the migrations
php vendor/bin/phinx migrate -e development

echo "Installation finished, the application is ready!"