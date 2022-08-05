# Pet Shop API
 [Backend Developer Task] [July 2022]

## Installation - Local

### 1. Clone or download the GitHub repo for this project locally

### 2. cd into the src folder inside the project folder

### 3. Install Composer Dependencies
```cmd
composer install
```
### 4. Install NPM Dependencies
```cmd
npm install
```
### 5. Create a copy of your .env file
Create a copy of **.env.example** file and rename it as **.env**
Update variables according to your environment.
Fill your database information here.

### 6. Generate an app encryption key
```cmd
php artisan key:generate
```

### 7. Setup JWT Signing Keys
Copy `private-key.pem` and `public-key.pk` in to `src\jwt_keys` folder. These files will be used to sign the jwt auth tokens.

### 8. Migrate the database
Once your credentials are in the .env file, now you can migrate your database.

    php artisan migrate

### 9. Seed the database
After the migrations are complete and you have the database structure required, then you can seed the database 

    php artisan db:seed
### 10. Run the project
Run following command to start the project. Click the link in the console to visit the project.

    php artisan serve

## Installation - Docker

### 1. Create a copy of your .env file in src folder
Create a copy of **.env.example** file and rename it as **.env**
Update variables according to your environment.
Fill your database information here.

### 2. Setup JWT Signing Keys
Copy `private-key.pem` and `public-key.pk` in to `src\jwt_keys` folder. These files will be used to sign the jwt auth tokens.

### 3. Make sure you have docker installed
  
### 4. Run docker image locally  
```  
docker-compose up -d --build site
```  
This image exposes following containers.
nginx - :80  
mysql - :3306  
php - :9000  
### 5. Setup the project

  Install composer

    docker-compose run --rm composer update  

Generate App Key

     docker-compose run --rm artisan key:generate

Migrate and run database seeder

    docker-compose run --rm artisan migrate:fresh --seed  
    
### 6. Visit the project
  Once you run above command go to http://localhost  
  
### 7. Stopping the Project
  

    docker-compose down  

  



## Testing

Package includes following tests.

 - **Unit Test**
 - **Feature Test**

Tests can be directly executed through the following command from src folder.
This project also tests the test cases inside the `packages\ashan\currency-exchange-rate` and `packages\ashan\state-machine`.

Local
 

     php artisan test

Docker

    docker-compose run --rm artisan test  

## Extra

### PHP Insight
Run following command to see the PHP insight output.

Local

     php artisan insights

Docker

    docker-compose run --rm artisan insights
## Swagger
Swagger doc is included in the following link.
[{APP_URL}/api/documentation/](http://127.0.0.1:8000/api/documentation/)

## License

[MIT](https://choosealicense.com/licenses/mit/)

-------------------
Copyright © 2022 Ashan Beruwalage - Developed with ♥
