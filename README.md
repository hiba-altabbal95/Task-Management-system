# Task_management_system

this project is Task Management system built in Laravel 10 

### Technologies Used:
- **Laravel 10**
- **PHP**
- **MySQL**
- **XAMPP** (for local development environment)
- **Composer** (PHP dependency manager)
- **Postman Collection**: Contains all API requests for easy testing and interaction with the API.

## Features
-Admin can add user and determine his role and can (update info of user, delete user, show info of user,show all users in DB).
-admin or Manager can add task in our system 
-Manager assigned a task to existing user
-A user can only edit status of task assigned to him
-admin or manager can filter tasks by status or priority




## Setting up the project

1. Clone the repository 

   git clone https://github.com/hiba-altabbal95/Task-Management-system.git
   
2. navigate to the project directory
  
    cd Task-Management-system  

3. install Dependencies: composer install 

4. create environment file  cp .env.example .env
  
5. edit .env file (DB_DATABASE=task_management)

6. Generate Application Key php artisan key:generate

7. Run Migrations To set up the database tables, run: php artisan migrate

8. Run this command to generate JWT Secret
   
   php artisan jwt:secret
   
9. Seed the Database
   
    php artisan db:seed
	
10. Run the Application
   
    php artisan serve

11. in file (Movie-Library-API.postman_collection) there are a collection of request to test api.




