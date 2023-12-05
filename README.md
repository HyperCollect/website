
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

# julia dependencies
to call julia from python, you need to install the julia python package:
```bash
python3 -m pip install --user julia
```
Then you need to start python3 shell and run:
```python
import julia
julia.install()
```

At the end you can check if you populate the database correctly by running:
```bash
python3 checkRepo.py
```