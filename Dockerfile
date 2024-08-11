FROM php:apache

# Install necessary libraries and intl extension
RUN apt-get update && apt-get install -y libicu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl mysqli pdo_mysql

# Clean up to reduce image size \
RUN apt-get clean && rm -rf /var/lib/apt/lists/*