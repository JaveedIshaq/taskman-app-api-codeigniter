# API Documentation

## Base URL

```
https://dev.farabicoders.com
```

## Authentication

All API endpoints (except login and register) require JWT authentication. Include the JWT token in the Authorization header:

```
Authorization: Bearer <your_jwt_token>
```

## Endpoints

### Authentication

#### Register User

```http
POST /auth/register
Content-Type: application/json

Request:
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123"
}

Response (201 Created):
{
    "status": 201,
    "message": "User registered successfully",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
        "id": 1,
        "name": "Test User",
        "email": "test@example.com"
    }
}

Error Response (400 Bad Request):
{
    "status": 400,
    "message": "Email already exists"
}
```

#### Login User

```http
POST /auth/login
Content-Type: application/json

Request:
{
    "email": "test@example.com",
    "password": "password123"
}

Response (200 OK):
{
    "status": 200,
    "message": "Login successful",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
        "id": 1,
        "name": "Test User",
        "email": "test@example.com"
    }
}

Error Response (401 Unauthorized):
{
    "status": 401,
    "message": "Invalid credentials"
}
```

### Categories

#### Get All Categories

```http
GET /categories

Response (200 OK):
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "name": "Work",
            "description": "Work related tasks",
            "created_at": "2025-01-07 15:46:38",
            "updated_at": "2025-01-07 15:46:38"
        }
    ]
}
```

#### Get Single Category

```http
GET /categories/{id}

Response (200 OK):
{
    "status": 200,
    "data": {
        "id": 1,
        "user_id": 1,
        "name": "Work",
        "description": "Work related tasks",
        "created_at": "2025-01-07 15:46:38",
        "updated_at": "2025-01-07 15:46:38"
    }
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Category not found or access denied"
}
```

#### Create Category

```http
POST /categories
Content-Type: application/json

Request:
{
    "name": "Personal",
    "description": "Personal tasks and reminders"
}

Response (201 Created):
{
    "status": 201,
    "message": "Category created successfully",
    "data": {
        "id": 2,
        "user_id": 1,
        "name": "Personal",
        "description": "Personal tasks and reminders",
        "created_at": "2025-01-07 15:46:38",
        "updated_at": "2025-01-07 15:46:38"
    }
}
```

#### Update Category

```http
PUT /categories/{id}
Content-Type: application/json

Request:
{
    "name": "Updated Name",
    "description": "Updated description"
}

Response (200 OK):
{
    "status": 200,
    "message": "Category updated successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "name": "Updated Name",
        "description": "Updated description",
        "created_at": "2025-01-07 15:46:38",
        "updated_at": "2025-01-07 15:47:38"
    }
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Category not found or access denied"
}
```

#### Delete Category

```http
DELETE /categories/{id}

Response (200 OK):
{
    "status": 200,
    "message": "Category deleted successfully"
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Category not found or access denied"
}
```

### Tasks

#### Get All Tasks

```http
GET /tasks

Response (200 OK):
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "category_id": 1,
            "title": "Complete Project",
            "description": "Finish the API documentation",
            "due_date": "2025-01-14 00:00:00",
            "priority": "high",
            "status": "pending",
            "created_at": "2025-01-07 15:46:38",
            "updated_at": "2025-01-07 15:46:38",
            "category_name": "Work"
        }
    ]
}
```

#### Get Single Task

```http
GET /tasks/{id}

Response (200 OK):
{
    "status": 200,
    "data": {
        "id": 1,
        "user_id": 1,
        "category_id": 1,
        "title": "Complete Project",
        "description": "Finish the API documentation",
        "due_date": "2025-01-14 00:00:00",
        "priority": "high",
        "status": "pending",
        "created_at": "2025-01-07 15:46:38",
        "updated_at": "2025-01-07 15:46:38",
        "category_name": "Work"
    }
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Task not found or access denied"
}
```

#### Create Task

```http
POST /tasks
Content-Type: application/json

Request:
{
    "category_id": 1,
    "title": "New Task",
    "description": "Task description",
    "due_date": "2025-01-14 00:00:00",
    "priority": "medium",
    "status": "pending"
}

Response (201 Created):
{
    "status": 201,
    "message": "Task created successfully",
    "data": {
        "id": 2,
        "user_id": 1,
        "category_id": 1,
        "title": "New Task",
        "description": "Task description",
        "due_date": "2025-01-14 00:00:00",
        "priority": "medium",
        "status": "pending",
        "created_at": "2025-01-07 15:46:38",
        "updated_at": "2025-01-07 15:46:38"
    }
}
```

#### Update Task

```http
PUT /tasks/{id}
Content-Type: application/json

Request:
{
    "title": "Updated Task",
    "description": "Updated description",
    "status": "in_progress"
}

Response (200 OK):
{
    "status": 200,
    "message": "Task updated successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "category_id": 1,
        "title": "Updated Task",
        "description": "Updated description",
        "due_date": "2025-01-14 00:00:00",
        "priority": "high",
        "status": "in_progress",
        "created_at": "2025-01-07 15:46:38",
        "updated_at": "2025-01-07 15:47:38"
    }
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Task not found or access denied"
}
```

#### Delete Task

```http
DELETE /tasks/{id}

Response (200 OK):
{
    "status": 200,
    "message": "Task deleted successfully"
}

Error Response (404 Not Found):
{
    "status": 404,
    "message": "Task not found or access denied"
}
```

## Error Responses

### General Error Format

```json
{
    "status": 400|401|403|404|500,
    "message": "Error message description"
}
```

### Common Error Codes

- 400 Bad Request: Invalid input data
- 401 Unauthorized: Missing or invalid authentication
- 403 Forbidden: Not allowed to access the resource
- 404 Not Found: Resource not found
- 500 Internal Server Error: Server-side error

## Notes

1. All timestamps are in MySQL DATETIME format (YYYY-MM-DD HH:MM:SS)
2. Task priority can be: "low", "medium", "high"
3. Task status can be: "pending", "in_progress", "completed"
4. The JWT token expires after 24 hours
