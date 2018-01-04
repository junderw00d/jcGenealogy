read -r -p "This procedure will permantley uninstall jcGenealogy. Are you sure you would like to continue? [Y/n]" proceed
if [ "$proceed" == "Y" ]
then
  echo "Connecting to database"
  . /etc/jcGenealogy/mysqlconf.sh
  echo "Deleting database"
  mysql -u$dbUser -p$dbPassword -se "DROP DATABASE jcGenealogy"
  echo "Deleting files"
  sudo rm /etc/jcGenealogy -r
  sudo rm /var/lib/jcGenealogy -r
  sudo rm /etc/apache2/conf-enabled/jcGenealogy.conf
  echo "All done. Goodbye."
else
  echo "Ok. Goodbye."
fi
