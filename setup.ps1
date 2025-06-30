composer install
npm install
npm run build
php artisan migrate --seed
php artisan storage:link
php artisan key:generate
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear