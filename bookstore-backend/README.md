## Backend (Laravel) :

<!-- Create your laravel project -->
# composer create-project laravel/laravel bookstore-backend

<!-- Database Setup: -->
# Set up your database configuration in the .env file.

<!-- Run migrations to create the necessary tables -->
# php artisan migrate

<!-- Manage book controller and model -->
# Create a model for books and a controller to handle CRUD operations.

# php artisan make:model Book

# php artisan make:controller BookController

<!-- Manage admin auth controller -->
# php artisan make:controller AdminAuthController

<!-- Manage dashboard controller -->
# php artisan make:controller DashboardController

<!-- Manage auth controller to handle apis -->
# php artisan make:controller AuthController

<!-- Manage seeder in the database tables with sample or default data.  -->
# php artisan make:seeder BooksTableSeeder
# php artisan make:seeder UserSeeder
# php artisan make:seeder AdminSeeder

<!-- Run seeders -->
# php artisan db:seed --class=BooksTableSeeder
# php artisan db:seed --class=UserSeeder
# php artisan db:seed --class=AdminSeeder

<!-- Manage book table migration -->
# php artisan make:migration create_books_table
