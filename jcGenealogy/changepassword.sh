#!/bin/bash

read -p "Enter the MySQL username: " dbUser
read -p "Enter the MySQL password: " dbPassword

sudo echo "\$mysqli = new mysqli(\"127.0.0.1\", \"$dbUser\", \"$dbPassword\", \"jcForum\");" | sudo tee /etc/jcGenealogy/mysqlconf.php
sudo echo -e "dbUser=\"$dbUser\"\ndbPassword=\"$dbPassword\"" | sudo dd status=none of=/etc/jcGenealogy/mysqlconf.sh
