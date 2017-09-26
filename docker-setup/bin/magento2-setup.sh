#!/bin/sh

echo "Initializing setup..."
MAGENTO_BASE_DOMAIN=$(echo $MAGENTO_BASE_URL | sed 's/http:\/\///g')
MAGENTO_BASE_DOMAIN=${MAGENTO_BASE_DOMAIN%/}
MAGENTO_BASE_URL=http://${MAGENTO_BASE_DOMAIN}/

cd /var/www/html
if [ -f ./app/etc/config.php ] || [ -f ./app/etc/env.php ]; then
    echo "Update Magento 2 base url to $MAGENTO_BASE_URL"
    sleep 5
    /usr/bin/php ./bin/magento setup:store-config:set --base-url="$MAGENTO_BASE_URL"
    /usr/bin/php ./bin/magento cache:flush
    echo "Magento is already installed (app/etc/config.php or app/etc/env.php exist)...."
    echo "Please add /etc/hosts to 127.0.0.1 $MAGENTO_BASE_DOMAIN"
    echo "Admin Login URL: ${MAGENTO_BASE_URL}adminlogin"
    echo "Username: admin"
    echo "Password: magento2admin"
    exit
fi

echo "Download Magento 2 ..."
if [ -f ./magento2-2.1.8.tar.gz ]; then
    magento2md5=$(md5sum ./magento2-2.1.8.tar.gz | cut -d ' ' -f 1)
    if [ $magento2md5 != "7d6009eeb1277ebb8869c511f3118c62" ]; then
        echo "Found corrupt magento 2 file, so delete and re download.."
        rm ./magento2-2.1.8.tar.gz
        curl -O http://pubfiles.nexcess.net/magento/ce-packages/magento2-2.1.8.tar.gz
    else
        echo "Already Download magento 2 so continue.."
    fi
    magento2md5=""
else
    curl -O http://pubfiles.nexcess.net/magento/ce-packages/magento2-2.1.8.tar.gz
fi
echo "Download Magento 2 Complete"

if [ -f ./magento2-2.1.8.tar.gz ]; then 
    echo "Unzip Magento 2 file..."
    tar zxf magento2-2.1.8.tar.gz
    echo "Unzip Magento 2 Complete file"
    rm magento2-2.1.8.tar.gz
else
    echo "Couldnt download please try again"
    exit;
fi

echo "Copy Mourya/Shopfinder Module"
mkdir -p ./app/code
cp -r /shopfinder/codes/Mourya ./app/code/Mourya
echo "Copy Mourya/Shopfinder Module Complete"

mkdir ./var/di
chmod -R 777 ./var
chown -R www-data. /var/www/html
chmod +x ./bin/magento

echo "Installing composer dependencies..."
/usr/bin/php /usr/local/bin/composer update

echo "Create mysql database and user"
mysql -e "CREATE DATABASE $MYSQL_DATABASE /*\!40100 DEFAULT CHARACTER SET utf8 */;"
mysql -e "CREATE USER ${MYSQL_USER}@localhost IDENTIFIED BY '${MYSQL_PASSWORD}';"
mysql -e "GRANT ALL PRIVILEGES ON ${MYSQL_DATABASE}.* TO '${MYSQL_USER}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

echo "Running Magento 2 setup script..."
/usr/bin/php ./bin/magento setup:install \
  --backend-frontname=adminlogin \
  --db-host=localhost \
  --db-name=$MYSQL_DATABASE \
  --db-user=$MYSQL_USER \
  --db-password=$MYSQL_PASSWORD \
  --base-url=$MAGENTO_BASE_URL \
  --admin-firstname=Admin \
  --admin-lastname=Admin \
  --admin-email=admin@admin.com \
  --admin-user=admin \
  --admin-password=magento2admin

chmod -R 777 ./var
chown -R www-data. /var/www/html

echo "The setup script has completed execution. Please add /etc/hosts to 127.0.0.1 $MAGENTO_BASE_DOMAIN"
echo "Admin Login URL: ${MAGENTO_BASE_URL}adminlogin"
echo "Username: admin"
echo "Password: magento2admin"
