### INSTALLATION GUIDE

> NOTE! THIS APPLICATION ONLY TESTED IN MYSQL AS DATABASE
- CLONE THIS REPOSITORY
- RENAME .env.example to .env
- GO TO CLONED FOLDER AND RUN
> composer install
> 
> npm install
> 
> php artisan key:generate
- INSERT YOUR DB CREDENTIALS ON .ENV
- AFTER PROVIDING THE DETAILS NEEDED RUN
> php artisan migrate --seed
- THEN RUN 
-
> npm run dev
> php artisan serve

-
- the application should run now

- DEFAULT CREDENTIALS:
     - username : admin
     - email : test@test.com
     - password : 123
