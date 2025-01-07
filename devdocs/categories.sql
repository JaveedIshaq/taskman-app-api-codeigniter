CREATE TABLE categories (
    id SERIAL PRIMARY KEY, -- Auto-incrementing primary key
    name VARCHAR(255) UNIQUE NOT NULL -- Name of the category (e.g., "College stuff")
);