# Docker-PHP-Apache-MySQL-PHPMyAdmin
Despliegue de contenedores Docker utilizando PHP 7.0, Apache, MySQL y PHPMyAdmin

# PASO 1.
*Descargar las imágenes de docker.*
* docker pull mysql:5
* docker pull php:7.0-apache
* docker pull phpmyadmin
# PASO 2.
Crear una carpeta de nombre API y guardar los archivos de conexión, apidoc, index, Service y BL.
Crear una carpeta con el nombre DataBase dentro de la carpeta de API.

# PASO 3.
*Ejecutar los contenedores.*
# Base de Datos.
* docker run -p 3306:3306 --name [nombre del contenedor] -v [ruta de la carpeta DataBase]:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=[contraseña] -d mysql:5
# Página.
* docker run -p [puerto]:80 --name [nombre del contenedor] -v [ruta de la carpeta API]:/var/www/html -d --link [nombre del contenedor de base de datos] php:7.0-apache
# phpMyAdmin.
* docker run -p [puerto]:80 --name [nombre del contenedor] -d --link [nombre del contenedor de base de datos]:db phpmyadmin

# PASO 4.
Crear una Base de datos
* docker exec -it [contenedor BD] /bin/bash
* mysql -u root -p
* CREATE DATABASE labsol;
* USE labsol;
* CREATE TABLE presencia (presencia_id INT NOT NULL AUTO_INCREMENT, direccion VARCHAR(45) NOT NULL, tiempoArea INT NOT NULL, last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY  (presencia_id));
* INSERT INTO presencia values (default, "entrada", 20, current_timestamp);
* exit
* exit
# PASO 5.
Configurar el contenedor de la página.
* docker exec -it [contenedor Apache] /bin/bash
* cd /
* docker-php-ext-install pdo pdo_mysql pdo_pgsql
* cd /usr/local/etc/php
* apt-get update
* apt-get install nano
* nano php.ini-development
* Buscar el apartado Dynamic Extensions, en la parte de "or with a path", agregar las lineas.
* extension=/usr/local/lib/php/extensions/no-debug-non-zts-20151012/pdo.so
* extension=/usr/local/lib/php/extensions/no-debug-non-zts-20151012/pdo_mysql.so
* nano php.ini-production y hacer lo mismo que el archivo anterior.
* exit
* docker restart [contenedor Apache]

*Nota
Editar el archivo de Conexion.php y en la linea $this->Host = "BaseDatos:3306";
Cambiar el nombre por el del contenedor.

  
