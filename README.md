<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# HR Management

Welcome to the HR Management API! This Laravel application is designed to handle HR management tasks efficiently. It includes features such
as user authentication, employee data management, job operations, employee logs, and various useful commands. The API ensures secure and
scalable HR management practices.

## Getting Started

To start using Project, follow these steps:

1. Clone the repository to your local machine:

   ```shell
   git clone https://github.com/abdulbasit-dev/hr-management-api.git
   cd hr-management-api
   ```

2. Install project dependencies using Composer:

   ```shell
   composer install
   ```

3. Copy the `.env.example` file and configure your environment variables:

   ```shell
   cp .env.example .env
   php artisan key:generate
   ```

4. Create and seed the database with fake data using the following command (optional):

   ```shell
   php artisan migrate --seed
   ```

5. Start the Laravel development server:

   ```shell
   php artisan serve
   ```

6. Base Url For the api will be:

   ```
   http://localhost:8000/api/v1
   ```

 <!-- use this website to view the cvs download -->

## Dependencies

The Project utilizes the following dependencies:

- [Laravel Framework](https://laravel.com) Laravel Framework
- [laravel/sanctum](https://laravel.com/docs/10.x/sanctum): A lightweight package for API authentication using Laravel's built-in features.
- [maatwebsite/excel](https://docs.laravel-excel.com/3.1/getting-started/): A package for importing and exporting Excel and CSV files in
  Laravel applications.

## Postman Collection

You will find the the postman collection in the root directory folder with file name **HR Management.postman_collection.json**
<br> and You can read the documentation from here, [Api Documentation](https://documenter.getpostman.com/view/12162986/2s9YXiahFs)

**NOTE:** In **"Export Employees"** Api you need click on "Send and Download" Button in postman, in order to the download the exported
Employee CSV file.

<img src="./public/send and download.png"  alt="Send and Download btn">

## Other Files

You will find In the root directory folder this two file:

1. **The Database File:** Use **laravel_hr-mangement.sql** file to export in your database in case if you did not populate your database
   with seed data using

```shell
 php artisan migrate --seed
```

2. **Export Employee Template:** Use the **import_employee.csv** file as the template to import data in **Import Employees** Api


## Test Email Sending with MailTrap

We have already set up email sending in this project, and we're using MailTrap, a testing environment for catching and inspecting emails.
You can check the emails we send from the application without signing up for MailTrap. We've provided the MailTrap credentials, so follow
the steps below:

1. **Visit MailTrap Inbox:** Open [MailTrap Inbox](https://mailtrap.io/inboxes/1432104/messages/3650415878) to view the emails sent from the
   application. This link will take you directly to the inbox where you can see the emails.

2. **Login to MailTrap:** Use the following MailTrap login credentials to access the inbox:

   - Email: basit99dev@gmail.com
   - Password: 12345678

3. **Check Received Emails:** In the MailTrap inbox, you'll find the emails that have been sent from the application. You can inspect the
   content, headers, and attachments of these emails.

## Commands:

#### 1- Delete Logs Older than 1 Month

This command deletes logs older than 1 month from the employee_logs table.

```shell
php artisan logs:delete
```

#### 2- Remove All Log Files

This command removes all log files from the storage directory.

```shell
php artisan logfiles:remove
```

#### 3- Insert Employees Based on Count

This command inserts employee data based on a given number with a progress bar.

```shell
php artisan employees:insert --count=100
```

#### 4- Export Database to SQL File

This command exports the database to an SQL file.

```shell
php artisan database:export
```

#### 5- Export All Employees to JSON File

This command exports all employees to a JSON file.

```shell
php artisan employees:export-json
```

## Not Implemented:

1. **TDD:** I did not implement test-driven development (TDD) tests for the endpoints.

