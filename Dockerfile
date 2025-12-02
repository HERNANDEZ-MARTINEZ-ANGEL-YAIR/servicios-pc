# Dockerfile para PHP
FROM php:8.2-cli

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Crear directorio de trabajo
WORKDIR /app

# Copiar todos los archivos
COPY . /app/

# Puerto
EXPOSE 8080

# Comando para iniciar
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
