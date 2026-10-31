# -------------------------------------------------------------
# Production Nginx Web Server
# -------------------------------------------------------------
FROM nginx:alpine

LABEL maintainer="SMA Islam Al-Madinah BSD"

# Copy Nginx server configuration
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy static public assets (including compiled Vite assets and Filament assets)
COPY public /var/www/html/public

EXPOSE 80 443

CMD ["nginx", "-g", "daemon off;"]
