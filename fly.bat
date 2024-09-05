cd %cd%
php artisan migrate:fresh
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=EmployeeSeeder