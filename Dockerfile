FROM php:8.2-apache

# Habilita mod_rewrite e headers para suporte ao streaming
RUN a2enmod rewrite headers

# Copia os arquivos da aplicação para o container
COPY . /var/www/html/

# Copia os arquivos costumizado do PHP
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Substitui o DocumentRoot padrão para apontar para public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Define permissões (ajuste conforme necessário)
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80
EXPOSE 80
