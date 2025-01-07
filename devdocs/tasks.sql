CREATE TABLE tasks (
    id SERIAL PRIMARY KEY, -- Auto-incrementing primary key
    user_id INT NOT NULL, -- Foreign key referencing the user who created the task
    title VARCHAR(255) NOT NULL, -- Title of the task
    date DATE NOT NULL, -- Date of the task
    start_time TIME NOT NULL, -- Start time of the task
    end_time TIME NOT NULL, -- End time of the task
    category_id INT NOT NULL, -- Foreign key referencing the category
    description TEXT, -- Optional description of the task
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of task creation
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Cascade delete if user is deleted
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE -- Cascade delete if category is deleted
);