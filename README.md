## Task Management System

## Overview

This is a RESTful API-based task management system developed with Laravel v11.x. It allows users to create, assign, and manage tasks efficiently.

## Prerequisites

-   PHP >= 8.2
-   Composer
-   MySQL

## Installation

#### 1- Clone the repository to your local machine:

    `git clone https://github.com/MohamedSaad0/task-mgt-app.git`

#### 2- Navigate to the project directory:

    `cd task-mgt-app`

#### 3- Install PHP dependencies using Composer:

    `composer install`

#### 4- Copy the `.env.example` file and rename it to `.env`:

    `cp .env.example .env`

#### 5- Generate an application key:

    `php artisan key:generate`

#### 6- Configure your .env file with your database credentials and any other necessary configurations.

#### 7- Migrate & seed the database:

    `php artisan migrate --seed`

#### 8- Serve the application:

    `php artisan serve`

## Usage

### \* Check Postman collection examples for elaboration.

### \* Register a new account or log in with existing credentials.

### \* Create tasks, assign them to users, and manage their statuses.
