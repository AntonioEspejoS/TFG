# Usa la imagen oficial de PHP 8.2 con Apache
FROM php:8.2.4-apache

# Instala las extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia el código fuente de tu aplicación al contenedor
COPY ProyectoTFG/ /var/www/html/ProyectoTFG
# Permisos para que puedan modificar las imagenes teniedno acceso a las carpetas del todo el proyecto
RUN chown -R www-data:www-data /var/www/html/ProyectoTFG