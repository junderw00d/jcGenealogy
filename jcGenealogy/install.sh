#!/bin/bash

sudo mkdir /var/lib/jcGenealogy
sudo mkdir /etc/jcGenealogy

read -p "Enter the MySQL username: " dbUser
read -p "Enter the MySQL password: " dbPassword
mysql -u$dbUser -p$dbPassword -se "CREATE DATABASE jcGenealogy"
echo "Setting up database structure (this may take a while)"
mysql jcGenealogy -u$dbUser -p$dbPassword < dbstructure.sql
sudo echo -e "<?php\ninclude \"/etc/jcGenealogy/mysqlconf.php\";\n?>" | sudo tee /etc/jcGenealogy/load.php
sudo echo -e "<?php\n\$mysqli = new mysqli(\"127.0.0.1\", \"$dbUser\", \"$dbPassword\", \"jcGenealogy\");\n?>" | sudo tee /etc/jcGenealogy/mysqlconf.php

read -p $"Enter what directory you would like the software to be located at (i.e., if you want it at localhost/familytree, enter 'familytree'): " directory
sudo echo -e "Alias /$directory /var/lib/jcGenealogy\n<Directory /var/lib/jcGenealogy/>\nOptions +FollowSymLinks\nAllowOverride All\n<IfVersion >= 2.3>\nRequire all granted\n</IfVersion>\n<IfVersion < 2.3>\norder allow,deny\nallow from all\n</IfVersion>\n</Directory>" | sudo tee /etc/apache2/conf-enabled/jcGenealogy.conf

sudo rm /var/lib/jcGenealogy/* -r
sudo cp -r web/* /var/lib/jcGenealogy
