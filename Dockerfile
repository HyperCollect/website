FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    python3 \
    python3-pip \
    wget

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pip3 install matplotlib python-dotenv requests mysql-connector-python --break-system-packages
RUN wget https://julialang-s3.julialang.org/bin/linux/x64/1.8/julia-1.8.1-linux-x86_64.tar.gz && tar zxvf julia-1.8.1-linux-x86_64.tar.gz
RUN cp -r julia-1.8.1 /opt/ && ln -s /opt/julia-1.8.1/bin/julia /usr/local/bin/julia
RUN python3 -m pip install --user julia --break-system-packages

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user