# pasta5

# Basic init && db fill
cd $workdir  
cp .env.example .env  
composer install  
cd public  
touch ../database/database.sqlite  
php ../artisan migrate:fresh  
php ../artisan db:seed  
php ../artisan serve  

# Run from docker hub
docker run -d -p 8000:8000 raikh/pasta5

