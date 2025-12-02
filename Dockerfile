# Dockerfile para aplicación PHP simple
FROM php:8.2-cli

WORKDIR /app

# Copiar toda la aplicación
COPY . /app/

# Puerto que usará Render
EXPOSE 8080

# Comando para iniciar servidor PHP
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
