# README #


### How do I get set up? ###

VHOST

     <VirtualHost *:80>
         ServerName performax.localhost
         DocumentRoot /var/www/performax/public
         SetEnv APPLICATION_ENV "development"
         <Directory /var/www/performax/public>
             DirectoryIndex index.php
             AllowOverride All
             Order allow,deny
             Allow from all
         </Directory>
     </VirtualHost>