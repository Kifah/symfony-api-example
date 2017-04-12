#!/usr/bin/env bash



###phpunit (dev only)

wget https://phar.phpunit.de/phpunit.phar && chmod +x phpunit.phar && mv phpunit.phar /usr/local/bin/phpunit

echo "update sql schemas.."
cd /srv/api && php bin/console doctrine:schema:update --force

echo "clear and prepare cache and logs"
chmod -R a+rw /var/cache/api/
chmod -R a+rw /var/log/api/

echo "install fixtures"
php bin/console hautelook:fixtures:load  --no-interaction

apache2-foreground
