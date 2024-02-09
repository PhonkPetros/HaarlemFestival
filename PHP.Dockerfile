FROM php:fpm

# Install system dependencies for SQL Server pdo_sqlsrv and sqlsrv
RUN apt-get update && apt-get install -y \
        gnupg \
        unixodbc-dev \
        g++ \
        && docker-php-ext-install pdo pdo_mysql mysqli

# Add Microsoft's official repository
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list

# Install SQL Server drivers and necessary tools
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y \
        msodbcsql17 \
        mssql-tools \
        unixodbc \
        && pecl install pdo_sqlsrv-5.10.0 sqlsrv-5.10.0 \
        && docker-php-ext-enable pdo_sqlsrv sqlsrv
