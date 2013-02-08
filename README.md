easygtd
=======

EasyGTD - Web Tools to Gettings Things Done

How to install
==============

EasyGTD is a Web Appz built in Symfony 1.4 within a mix of software developers (Warning: There is spanish-english inside the code - sorry) , follow this steps to install it under Linux distro:

1) Configure a dev domain in your /etc/hosts file like this:
   127.0.0.1  easygtd-dev.com
2) Add a virtual host to your Apache 2 configuration, you can create a file call easygtd-dev.conf under /etc/apache2/sites-enabled/

   My easygtd-dev.conf file is: 
   <VirtualHost *:80>
     Servername easygtd-dev.com
     DocumentRoot /home/leobarrientosc/PROYECTOS/easygtd/src/web
     Alias /sf /home/leobarrientosc/PROYECTOS/easygtd/src/lib/vendor/symfony/data/web/sf
     <Directory "/home/leobarrientosc/PROYECTOS/easygtd/src/web">
       Options Indexes Multiviews FollowSymlinks
       AllowOverride All
     </Directory>
   </VirtualHost>

   * /home/leobarrientosc/PROYECTOS/ is the path to my working copy.
   * You must read the symfony config standard to know why the document root is /web


3) A mysql database should be used, see the params in src/config/databases.yml and create a database

   CREATE DATABASE easygtd_dev;
   GRANT ALL PRIVILEGES ON easygtd_dev.* TO easygtd_dev_user@localhost IDENTIFIED BY 'easygtd_dev_password';

4) Go to src and create the folders:  /log and /cache and make them 777 chmod -R 777 cache log (Both folders are ignored in GIT)

5) Load the DB Tables: php symfony doctrine:insert-sql

6) Load the sample data: php symfony doctrine:data-load

7) Clear the cache: php symfony ccc

8) Restart Apache and open http://easygtd-dev.com you can log into the frontend appz in using: easygtd and password easygtd

   -- The appz is using 2 languages: /es or /en in the url see frontend/config/filters.yml and apps/frontend/lib/SwitchLanguageFilter.class.php

9) If you want to manage users go to http://easygtd-dev.com/backend_dev.php (The user easygtd is super admin - see fixtures.yml)   

10) If you want to build or extends the model using schema.yml you should rebuild the model, see php symfony doctrine options.

11) There is a few batch added under /batch folder.


¡Enjoy!

Rules
=====

0) Read The GTD Book - mandatory.
1) Using only Open Source Tools (ramework, scripts, icons, images, etc).
2) Use Symfony coding standars. 
3) Use JQuery as javascript framework
4) If you want to modify the model schema.yml please talk first to @leobarrientosc

-- Add more rules.

Credits
=======

The idea of this project came from Fernando Monera.

The main architecture and most of the look and feel and business logic have been made by @leobarrientosc

The code have been written by @leobarrientosc & Alex Luengo of Open Sistemas.

The commercial idea and management have been made by Luis Flores, Pamela Castro, Fernando Monera & @leobarrientosc









