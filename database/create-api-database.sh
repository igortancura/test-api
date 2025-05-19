#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS api;
    GRANT ALL PRIVILEGES ON \`api%\`.* TO '$MYSQL_USER'@'%';
EOSQL
