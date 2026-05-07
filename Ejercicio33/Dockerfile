FROM php:8.1-apache
COPY . /var/www/html/
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html
CMD ["apache2-foreground"]
EXPOSE 80
 
