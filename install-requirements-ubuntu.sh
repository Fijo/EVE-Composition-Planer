sudo apt-get install apache2
sudo apt-get install php5
sudo apt-get install mysql-server
sudo apt-get install php5-mysql
sudo apt-get install phpmyadmin
sudo a2enmod rewrite
sudo service apache2 reload

sudo apt-get install nodejs
sudo apt-get install npm

sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys 3FA7E0328081BFF6A14DA29AA6A19B38D3D831EF -y
echo "deb http://download.mono-project.com/repo/debian wheezy main" | sudo tee /etc/apt/sources.list.d/mono-xamarin.list
sudo apt-get update -q
sudo apt-get install mono-complete

cd ~
sudo curl -sS https://getcomposer.org/installer| php
sudo mv composer.phar /usr/bin/composer