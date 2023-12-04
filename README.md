
# First build - php

## requirements
- php
- composer
- env file (use .env.example as a template). the following variables need to be set:
  - DB_DATABASE
  - DB_USERNAME
  - DB_PASSWORD

```bash
composer install
php artisan migrate:fresh
cd website/storage/app/public && git clone https://github.com/HyperCollect/datasets
php artisan storage:link
php artisan serve
```

On first run, if you open the website, you will need to generate the api key.
You can populate the database using the python script.


# python dependencies
pip install -r requirements.txt

```bash
python3 checkRepo.py
```