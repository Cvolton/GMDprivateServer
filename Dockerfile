FROM php:8.1.31-apache

# Dockerfile's Metadata
LABEL name="GMDprivateServer" \
      description="A Geometry Dash Server Emulator"

# Install necessary dependencies
RUN apt-get update && apt-get install -y --no-install-recommends git ca-certificates && \
    docker-php-ext-install pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www/html

# Clone the repository
ARG BRANCH=master
RUN git clone --branch ${BRANCH} https://github.com/MegaSa1nt/GMDprivateServer.git . && \
    chown -R www-data:www-data /var/www/html

# Export Apache's port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
