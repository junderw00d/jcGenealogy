#!/bin/bash

sudo mkdir /var/lib/jcGenealogy
sudo mkdir /etc/jcGenealogy

read -p "Enter the MySQL username: " dbUser
read -p "Enter the MySQL password: " dbPassword
mysql -u$dbUser -p$dbPassword -se "CREATE DATABASE jcGenealogy"
mysql jcGenealogy -u$dbUser -p$dbPassword < dbstructure.sql
sudo echo "<?php\$mysqli = new mysqli(\"127.0.0.1\", \"$dbUser\", \"$dbPassword\", \"jcForum\");?>" | sudo tee /etc/jcGenealogy/mysqlconf.php

read -p "Enter what directory you would like the software to be located at (i.e., if you want it at localhost/familytree, enter 'familytree'): " directory
sudo echo "Alias /$directory /var/lib/jcGenealogy\n<Directory /var/lib/jcGenealogy/>\nOptions +FollowSymLinks\nAllowOverride All\n<IfVersion >= 2.3>\nRequire all granted\n</IfVersion>\n<IfVersion < 2.3>\norder allow,deny\nallow from all\n</IfVersion>\n</Directory>" | sudo tee /etc/apache2/conf-enabled/jcGenealogy.conf


sudo mv web/register.php /var/lib/jcGenealogy/register.php

sudo echo "Installation successful. " | sudo tee /var/lib/jcGenealogy/index.html
