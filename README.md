# Assigment



### Step 1: Setup .env File

Rename .env.example to .env in root directory


### Step 2 : Install Composer

```bash
composer install
```

### Step 3 : DB migration

```bash
php artisan migrate:install

php artisan migrate

```

### Step 4 : DB Seeding for admin table

```bash
php artisan db:seed --class=AdminTableSeeder
```

### Step 5  : Import Api details to PostMan Client

Please import the file assignment.postman_collection.json in root directory in to your postman to access the API's


### Step 6 : Use the below credentails for admin login

```bash
username admin@epl.com

password:password
```








