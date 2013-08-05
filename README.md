# Hoobr Example Site

## Installing on a RaspberryPi

    apt-get update
    apt-get install git
    apt-get install npm
    apt-get install apache2
    apt-get install php5 libapache2-mod-php5
    a2enmod rewrite
    cd /var/www
    git clone https://github.com/ricallinson/hoobr-example-site.git
    cd ./hoobr-example-site/httpd/
    ./npm.install

Once installed you need to update the appache config and change `AllowOverride All` to `AllowOverride None`;

    nano /etc/apache2/sites-enabled/000-default

    <Directory /var/www/>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Order allow,deny
            allow from all
    </Directory>

Now restart apache;

    /etc/init.d/apache2 restart
