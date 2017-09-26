#!/bin/sh
echo "Service start"
/bin/bash /usr/local/bin/magento2-setup.sh &
if ! [ -f /var/www/html/app/etc/config.php ]; then
    mysqld --defaults-file=/etc/mysql/my.cnf --initialize --user=mysql
fi
/usr/bin/supervisord -n -c ${supervisor_conf}
