#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS dhgs;
    GRANT ALL PRIVILEGES ON \`dhgs%\`.* TO '$MYSQL_USER'@'%';
EOSQL
