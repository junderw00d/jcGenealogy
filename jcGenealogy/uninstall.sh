read -r -p "This procedure will permantley uninstall jcGenealogy. Are you sure you would like to continue? [Y/n]" proceed
if [ "$proceed" == "Y" ]
then
  . /etc/jcGenealogy/mysqlconf.sh
  mysql -u$dbUser -p$dbPassword -se "DROP DATABASE jcGenealogy"
  sudo rm /etc/jcGenealogy -r
  sudo rm /var/lib/jcGenealogy -r
  sudo rm /etc/apache2/conf-enabled/jcGenealogy.conf
fi
