FROM node:20.17.0-alpine AS node

#----------------
# BASE
#----------------
FROM webdevops/php-nginx:8.2-alpine as base

WORKDIR /var/www/html

#define nginx config with root folder
ENV TZ=Asia/Tokyo PHP_DATE_TIMEZONE=Asia/Tokyo APP_TIMEZONE=Asia/Tokyo WEB_DOCUMENT_ROOT=/var/www/html/public FPM_REQUEST_TERMINATE_TIMEOUT=300 

#define build time ARGS and Environments
ARG VITE_BUILD_DIST=assetsmanifest.json
ENV APP_VERSION=0.1.0

#----------------
# NON PRODUCTION DEPENDENCIES
#----------------
FROM base as devdependencies

#Install NODEJS and Other npm tools
COPY --from=node /usr/lib /usr/lib
COPY --from=node /usr/local/lib /usr/local/lib
COPY --from=node /usr/local/include /usr/local/include
COPY --from=node /usr/local/bin /usr/local/bin

#----------------
# DEVELOPMENT
#----------------
FROM devdependencies as development

# Set development env
ENV APP_ENV=local
ENV NODE_ENV=development
ENV CONTAINER_UID=sail

#Sail group and user
ARG WWWGROUP
RUN set -ex && apk --no-cache add sudo
RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail
RUN chmod g+rwx -R /root
RUN usermod -a -G root sail
RUN userdel nginx
RUN userdel application
RUN sed -i -e "s/nginx;/sail;/" /opt/docker/etc/nginx/nginx.conf
RUN chown sail:sail -R /var/lib/nginx

# Copy entrypoint configs
COPY ./docker/dev/supervisor-npm.conf /opt/docker/etc/supervisor.d/
COPY ./docker/dev/start-development.sh /opt/docker/provision/entrypoint/start-development.sh
RUN chmod +x /opt/docker/provision/entrypoint/start-development.sh
ENTRYPOINT [ "/opt/docker/provision/entrypoint/start-development.sh" ]

#----------------
# SETUP
#----------------
FROM devdependencies as setup

# copy only config files needed for npm installation, this will benefit from docker layer caching
COPY package*.json *.config.js ./
RUN npm config set fetch-retry-mintimeout 100000 && \
    npm config set fetch-retry-maxtimeout 100000 && \
    npm ci

#----------------
# TEST
#----------------
FROM setup as test

# Copy necessary files for unit testing frontend
COPY ./resources/js ./resources/js
# Frontend unit test
# RUN npm run test

# Copy necessary files for unit testing backend
RUN  mkdir -p /home/nginx/.composer

# Install all composer packages for running test
USER nginx
COPY ./ ./
USER root
RUN chmod o+w ./storage/ -R
RUN chmod o+w ./bootstrap/cache -R
USER nginx
RUN composer install
USER root

# Backend unit test
RUN php artisan test --testsuite=Unit 

#----------------
# BUILD
#----------------
FROM devdependencies as build

# Copy setup project files
COPY --from=test /var/www/html/node_modules ./node_modules

# set env variables for build
ENV NODE_ENV=production

# Copy and create necessary files for frontend building
COPY package*.json *.config.js ./
COPY ./resources ./resources
# Build frontend
RUN npm run build

# Copy and create necessary files for backend building 
RUN  mkdir -p /home/nginx/.composer
COPY composer.* ./

# Build Backend
# Install necessary composer packages only for production
USER nginx
RUN composer install --no-scripts --no-dev --no-autoloader
USER root

# Copy whole project files, except the one in .dockerignore
COPY ./ ./
RUN composer dump-autoload --no-dev --optimize

#----------------
# PRODUCTION
#----------------
FROM base as production

# set env to production
ENV APP_ENV=production

# Copy needed files from build
COPY --from=build "/var/www/html/public" "./public"
COPY --from=build /var/www/html/vendor ./vendor

# Copy whole project files, except the one in .dockerignore
COPY ./ ./
RUN chown -R application:application /var/www/html

# Laravel Cache
RUN php artisan route:clear && php artisan view:clear \
    && php artisan route:cache && php artisan view:cache && touch .env && php artisan key:generate

EXPOSE 80

# Copy start script
COPY ./docker/start-production.sh /scripts/start-production.sh 
RUN chmod +x /scripts/start-production.sh

# Cleanup
RUN rm -rf ./resources/js \
	&& rm -rf ./resources/css ./docker

# Start Application
ENTRYPOINT ["/scripts/start-production.sh"]
