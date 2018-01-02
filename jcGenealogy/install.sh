#!/bin/bash

sudo mkdir /var/lib/jcGenealogy
sudo mkdir /etc/jcGenealogy

read -p "Enter the MySQL username: " dbUser
read -p "Enter the MySQL password: " dbPassword

mysql -u$dbUser -p$dbPassword -se "CREATE DATABASE jcGenealogy"

sudo echo "\$mysqli = new mysqli(\"127.0.0.1\", \"$dbUser\", \"$dbPassword\", \"jcForum\");" | sudo tee /etc/jcGenealogy/mysqlconf.php

sudo echo "Alias /jcGenealogy /var/lib/jcGenealogy\n<Directory /var/lib/jcGenealogy/>\nOptions +FollowSymLinks\nAllowOverride All\n<IfVersion >= 2.3>\nRequire all granted\n</IfVersion>\n<IfVersion < 2.3>\norder allow,deny\nallow from all\n</IfVersion>\n</Directory>" | sudo tee /etc/apache2/conf-available/jcGenealogy.conf

sudo wget https://raw.githubusercontent.com/KoalaMuffin/jcGenealogy/master/jcGenealogy/web/register.php -O /var/lib/jcGenealogy/register.php

sudo echo "<a href='register.php'>register</a>" | sudo tee /var/lib/jcGenealogy/index.html
