# Info

Test the live project at [Site](http://hypergraphrepository.di.unisa.it/)
If you are using Arc Browser, you can use the dark mode boost [Boost](https://arc.net/boost/6C5AFA0C-C15D-4772-B8EA-3F398DEC8FAA)

## Datasets info

You can deeply investigate all the infos about datasets at [Repository](https://github.com/HypergraphRepository/datasets)

# RUNNING THE project

## requirements
- php
- composer
- env file (use .env.example as a template). the following variables need to be set:
  - DB_DATABASE
  - DB_USERNAME
  - DB_PASSWORD
  - GIT_USERNAME
  - GIT_TOKEN

# To run locally
```bash
composer install
php artisan migrate:fresh
cd website/storage/app/public && git clone https://github.com/HypergraphRepository/datasets && git clone https://github.com/geon0325/MoCHy.git && git config credential.helper store 
php artisan storage:link
php artisan serve
php artisan icons:cache
```

On first run, if you open the website, you will need to generate the api key through the button on landing page.
You can populate the database using the python script.

## python dependencies
pip install -r requirements.txt

you can generate a venv inside scripts folder and install the dependencies there:
```bash
python3.10 -m venv venv
. venv/bin/activate
pip3 install matplotlib python-dotenv requests mysql-connector-python
python3 -m pip install julia
```

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

add Suppressor and SimpleHypergraph packages to julia through package manager


At the end you can check if you populate the database correctly by running inside scripts folder:
```bash
python3 checkRepo.py
```

You can pull update repository of dataset by running:
```bash
bash gitPull.sh
```

if you have setup correctly the repository, you can run the scheduler locally to activate the cron jobs:
```bash
php artisan schedule:work
```
Look at the cron job section to set up a cron job on your machine.

# Docker build

Change hgraph.conf file to point nginx to localhost
```bash
server {
    listen       80;
    server_name  localhost;

    root /var/www/public;
    index index.php index.html;
    
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
}
```

Depending on the architecture of your machine, you have to modify the env file to build the sys.so image
```bash
DOCKER_PLATFORM="linux/amd64"
```

To start or stop the docker compose with:
```bash
docker compose up -d (start in background)
docker compose down (-v to remove volumes)
```
After the dockers are up, you can run the migration to initialize the database and start a shell in the container
```bash
docker exec -it hgraph php artisan migrate:fresh
docker exec -it hgraph bash
```
Then, while in the hgraph docker (in the folder var/www), you have to copy (or move) the custom julia image to the scripts folder then
```bash
cp ../../../sysimage/sys.so scripts/
python3 scripts/updateDB.py
```

If you want to rebuild images after a change, run:
```bash
docker compose up --build 
docker-compose up -d --build <service_name> --no-cache
```

If you want to rebuild images without cache, run:
```bash
docker compose build --no-cache
```

If you want to see the logs, run:
```bash
docker compose logs -f -t
```

To use the julia script, compile a custom system image for PyJulia, run
```bash
python3 -m julia.sysimage sys.so
```

To build a single service
```bash
docker compose build name_service
```

To run a command inside the docker
```bash
sudo docker exec -it hgraph php artisan <command>
```

Enter in postgres container
```bash
docker exec -it website-postgres-1 psql <namedb> <username>
```

# cron job

To run the scheduler with the scripts, is good practice to set up a cron job this way:
```bash
crontab -e
```
and insert the following line:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

To renew certificate with certbot, run:
```bash
docker compose run --rm certbot renew
```
You can also add a cron job to renew the certificate automatically:
```bash
@monthly docker compose -f /path-to-your-project/docker-compose.yml run --rm certbot renew
```
# Jupyter Notebook

To add your Notebook files simply place them in the following project folder: 
```
/storage/app/public/notebooks/
```

Also, it is important to know that Jupyter Notebook files cannot be edited or created through the web page.