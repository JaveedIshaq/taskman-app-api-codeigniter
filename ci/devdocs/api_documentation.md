# API Documentation

## Authentication Endpoints

### Register User
```http
POST /auth/register
Content-Type: application/json

Request:
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}

Response (201 Created):
{
    "status": 201,
    "message": "User registered successfully",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    }
}

Error Response (400 Bad Request):
{
    "status": 400,
    "messages": {
        "email": "Email already exists",
        "password": "Password must be at least 6 characters long"
    }
}
```

### Login
```http
POST /auth/login
Content-Type: application/json

Request:
{
    "email": "john@example.com",
    "password": "password123"
}

Response (200 OK):
{
    "status": 200,
    "message": "Login successful",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    }
}

Error Response (401 Unauthorized):
{
    "status": 401,
    "message": "Invalid password"
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "User not found"
}
```

## Task Endpoints
All task endpoints require authentication. Include the JWT token in the Authorization header:
```http
Authorization: Bearer <your_jwt_token>
```

### Get All Tasks
```http
GET /tasks

Response (200 OK):
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "title": "Meeting with Client",
            "date": "2025-01-10",
            "start_time": "09:00:00",
            "end_time": "10:00:00",
            "category_id": 1,
            "category_name": "Work",
            "description": "Discuss project requirements",
            "created_at": "2025-01-07 19:51:25"
        },
        // ... more tasks
    ]
}

Error Response (401 Unauthorized):
{
    "status": 401,
    "message": "Access denied. Invalid or missing token."
}
```

### Get Single Task
```http
GET /tasks/{id}

Response (200 OK):
{
    "status": 200,
    "data": {
        "id": 1,
        "user_id": 1,
        "title": "Meeting with Client",
        "date": "2025-01-10",
        "start_time": "09:00:00",
        "end_time": "10:00:00",
        "category_id": 1,
        "category_name": "Work",
        "description": "Discuss project requirements",
        "created_at": "2025-01-07 19:51:25"
    }
}

Error Response (403 Forbidden):
{
    "status": 403,
    "message": "You do not have permission to view this task"
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Task not found"
}
```

### Create Task
```http
POST /tasks
Content-Type: application/json

Request:
{
    "title": "Meeting with Client",
    "date": "2025-01-10",
    "start_time": "09:00:00",
    "end_time": "10:00:00",
    "category_id": 1,
    "description": "Discuss project requirements"
}

Response (201 Created):
{
    "status": 201,
    "message": "Task created successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "title": "Meeting with Client",
        "date": "2025-01-10",
        "start_time": "09:00:00",
        "end_time": "10:00:00",
        "category_id": 1,
        "category_name": "Work",
        "description": "Discuss project requirements",
        "created_at": "2025-01-07 19:51:25"
    }
}

Error Response (400 Bad Request):
{
    "status": 400,
    "messages": {
        "title": "The title field is required",
        "date": "The date field must be a valid date"
    }
}
```

### Update Task
```http
PUT /tasks/{id}
Content-Type: application/json

Request:
{
    "title": "Updated Meeting Title",
    "date": "2025-01-11",
    "start_time": "10:00:00",
    "end_time": "11:00:00",
    "category_id": 1,
    "description": "Updated description"
}

Response (200 OK):
{
    "status": 200,
    "message": "Task updated successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "title": "Updated Meeting Title",
        "date": "2025-01-11",
        "start_time": "10:00:00",
        "end_time": "11:00:00",
        "category_id": 1,
        "category_name": "Work",
        "description": "Updated description",
        "created_at": "2025-01-07 19:51:25"
    }
}

Error Response (403 Forbidden):
{
    "status": 403,
    "message": "You do not have permission to update this task"
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Task not found"
}
```

### Delete Task
```http
DELETE /tasks/{id}

Response (200 OK):
{
    "status": 200,
    "message": "Task deleted successfully"
}

Error Response (403 Forbidden):
{
    "status": 403,
    "message": "You do not have permission to delete this task"
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Task not found"
}
```

## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Categories Table
```sql
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tasks Table
```sql
CREATE TABLE tasks (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    category_id INT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

## Authentication
- All task endpoints require a valid JWT token
- Token expires after 24 hours
- Token must be included in the Authorization header as a Bearer token
- Invalid or expired tokens will receive a 401 Unauthorized response
