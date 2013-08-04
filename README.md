# Hoobr Example Site

The open source experiment for creating a content management system that's flexible but not complex.

## Installing on a RaspberryPi

You'll need to make `.htaccess` active.

	apt-get update
	apt-get install git
	apt-get install npm
	apt-get install apache2
	apt-get install php5 libapache2-mod-php5
	/etc/init.d/apache2 restart
	cd /var/www
	git clone https://github.com/ricallinson/hoobr-example-site.git
	cd ./hoobr-example-site/httpd/
	./npm.install
