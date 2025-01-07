-- First, let's create a default user if one doesn't exist
INSERT INTO users (name, email, password, created_at)
SELECT 'Default User', 'default@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'default@example.com');

-- Get the user_id for our categories
SET @default_user_id = (SELECT id FROM users WHERE email = 'default@example.com');

-- Now insert categories with the user_id
INSERT INTO categories (user_id, name, description, created_at, updated_at) VALUES
(@default_user_id, 'College stuff', 'Tasks and activities related to college', NOW(), NOW()),
(@default_user_id, 'Work', 'Professional tasks and responsibilities', NOW(), NOW()),
(@default_user_id, 'Social life', 'Social events and activities', NOW(), NOW()),
(@default_user_id, 'Study', 'Study-related tasks and materials', NOW(), NOW()),
(@default_user_id, 'Personal project', 'Personal development and side projects', NOW(), NOW()),
(@default_user_id, 'Home', 'Home-related tasks and chores', NOW(), NOW());
