#!/bin/bash

runningDirectory="$( cd "$( dirname "${BASH_SOURCE[0]}" )" > /dev/null && pwd )"

sudo mkdir /var/lib/jcGenealogy
sudo mkdir /etc/jcGenealogy

sudo mv "$runningDirectory/checkuser.php" /etc/jcGenealogy/

function getCredentials {
  read -r -p "Enter the MySQL username: " dbUser
  read -s -r -p "Enter the MySQL password: " dbPassword
}
getCredentials
until mysql -u$dbUser -p$dbPassword > /dev/null 2>&1 -e ";" ; do
  echo "Incorrect username or password. Try again"
  getCredentials
done

mysql -u$dbUser -p$dbPassword -se "DROP DATABASE IF EXISTS jcGenealogy"
mysql -u$dbUser -p$dbPassword -se "CREATE DATABASE jcGenealogy"
echo -e "\nSetting up database structure (this may take a while)"
mysql jcGenealogy -u$dbUser -p$dbPassword < "$runningDirectory/dbstructure.sql"

sudo echo -e "<?php\ninclude \"/etc/jcGenealogy/mysqlconf.php\";\n?>" | sudo dd status=none of=/etc/jcGenealogy/load.php
sudo echo -e "<?php\n\$mysqli = new mysqli(\"127.0.0.1\", \"$dbUser\", \"$dbPassword\", \"jcGenealogy\");\n?>" | sudo dd status=none of=/etc/jcGenealogy/mysqlconf.php

sudo echo -e "dbUser=\"$dbUser\"\ndbPassword=\"$dbPassword\"" | sudo dd status=none of=/etc/jcGenealogy/mysqlconf.sh

read -r -p $"Enter what directory you would like the software to be located at (i.e., if you want it at localhost/familytree, enter 'familytree'): " directory
sudo echo -e "Alias /$directory /var/lib/jcGenealogy/web\n<Directory /var/lib/jcGenealogy/web>\nOptions +FollowSymLinks\nAllowOverride All\n<IfVersion >= 2.3>\nRequire all granted\n</IfVersion>\n<IfVersion < 2.3>\norder allow,deny\nallow from all\n</IfVersion>\n</Directory>" | sudo sudo dd status=none of=/etc/apache2/conf-enabled/jcGenealogy.conf
sudo service apache2 restart

# sudo rm /var/lib/jcGenealogy/* -r
sudo cp -r "$runningDirectory/web/" /var/lib/jcGenealogy
