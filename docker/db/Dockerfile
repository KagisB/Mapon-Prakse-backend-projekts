FROM mysql:latest
ENV MYSQL_DATABASE carRoute
COPY init.sql /docker-entrypoint-initdb.d/
EXPOSE 3306