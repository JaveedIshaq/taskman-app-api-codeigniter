CREATE TABLE users (
    id SERIAL PRIMARY KEY, -- Auto-incrementing primary key
    name VARCHAR(255) NOT NULL, -- User's full name
    email VARCHAR(255) UNIQUE NOT NULL, -- Unique email for login
    password VARCHAR(255) NOT NULL, -- Hashed password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of user creation
);