# !/bin/bash
#
echo "Customizing Raspbian for Connected BeeHive..."
echo "1. Update package repository..."
sudo apt-get -y update

# Upgrade the repository to point to the latest locations
echo "2. Upgrade to latest..."
sudo apt-get -y upgrade

# Install all the required packages. Following are the required packages
echo "3. Installing required software packages..."
sudo apt-get -y install apache2
sudo apt-get -y install php
sudo apt-get -y install mariadb-client
sudo apt-get -y install mariadb-server
sudo apt-get -y install php-mysql
sudo apt-get -y install phpmyadmin
sudo apt-get -y install i2c-tools
sudo apt-get -y install libcurl4-openssl-dev
sudo apt-get -y install libmysqlcppconn-dev

# Clean-up the installation
echo "4. Remove un-needed packages..."
sudo apt-get -y autoremove

# Configure Apache
echo "5. Configuration Apache2..."
sudo a2enmod cgi
sudo a2enmod rewrite
sudo usermod -G video www-data
sudo usermod -a -G i2c www-data
sudo service apache2 restart

echo "Customization Complete..."

