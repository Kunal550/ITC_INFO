# Laravel Student CRUD API

This is a simple Student CRUD (Create, Read, Update, Delete) API built with Laravel. It allows you to manage student records, including their name, email, and phone number.

## Requirements

- PHP 8.x or higher
- Composer
- Laravel 8.x or higher
- MySQL (or any database you prefer)

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/Kunal550/ITC_INFO.git
    ```

2. Navigate to the project directory:
    ```bash
    cd studentCrud
    ```

3. Install the dependencies:
    ```bash
    composer install
    ```

4. Create a `.env` file by copying the example:
    ```bash
    cp .env.example .env
    ```

5. Set up your database credentials in the `.env` file:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=student_crud
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Run the database migrations:
    ```bash
    php artisan migrate
    ```

## API Endpoints

### 1. **list a Student**

**Endpoint:** `GET /api/students`

**Response Body:**
[
  {
    "id": 6,
    "name": "Infrastructure",
    "email": "kunalbusinesspro@gmail.com",
    "phone": "9398377155",
    "status": "A",
    "created_at": "2025-04-15T10:01:47.000000Z",
    "updated_at": "2025-04-15T10:01:47.000000Z"
  },
  {
    "id": 7,
    "name": "ABC Rahul",
    "email": "abc@gmail.com",
    "phone": "9936547825",
    "status": "A",
    "created_at": "2025-04-15T10:07:15.000000Z",
    "updated_at": "2025-04-15T10:07:15.000000Z"
  }]


### 2. **Create a Student**

**Endpoint:** `POST /api/students`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "phone": "1234567890"
}

### 3. **show a Student**

**Endpoint:** `POST /api/students/{id}`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "phone": "1234567890"
}

### 4. **Edit & Update a Student**

**Endpoint:** `PUT /api/students/{id}`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "phone": "1234567890"
}

### 5. **Delete a Student**

**Endpoint:** `Delete /api/students/{id}`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "phone": "1234567890"
}
