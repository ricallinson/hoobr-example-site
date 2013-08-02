# hoobr

Just for fun.

## Installin on RaspberryPi

You'll need to make `.htaccess` active.

	apt-get update
	apt-get install git
	apt-get install npm
	apt-get install apache2
	apt-get install php5 libapache2-mod-php5
	/etc/init.d/apache2 restart
	cd /var/www
	git clone https://github.com/ricallinson/hoobr.git
	cd hoobr/httpd/
	./npm.install
