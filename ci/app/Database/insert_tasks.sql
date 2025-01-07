-- First create user for Shafa Salsabilia if not exists
INSERT INTO users (name, email, password, created_at)
SELECT 'Shafa Salsabilia', 'shafa@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'shafa@example.com');

-- Get Shafa's user_id
SET @shafa_id = (SELECT id FROM users WHERE email = 'shafa@example.com');

-- Get category IDs based on names
SET @college_id = (SELECT id FROM categories WHERE name = 'College stuff' AND user_id = @shafa_id);
SET @work_id = (SELECT id FROM categories WHERE name = 'Work' AND user_id = @shafa_id);
SET @social_id = (SELECT id FROM categories WHERE name = 'Social life' AND user_id = @shafa_id);
SET @study_id = (SELECT id FROM categories WHERE name = 'Study' AND user_id = @shafa_id);
SET @personal_id = (SELECT id FROM categories WHERE name = 'Personal project' AND user_id = @shafa_id);
SET @home_id = (SELECT id FROM categories WHERE name = 'Home' AND user_id = @shafa_id);

-- Insert tasks with proper schema fields and dynamic category IDs
INSERT INTO tasks (user_id, category_id, title, description, due_date, priority, status, created_at, updated_at) 
VALUES 
-- College tasks (College stuff category)
(@shafa_id, @college_id, 'Complete Math Assignment', 'Finish chapter 5 problems', '2025-01-07 12:00:00', 'high', 'pending', NOW(), NOW()),
(@shafa_id, @college_id, 'Write Essay', 'Write a 1000-word essay on history', '2025-01-07 16:00:00', 'medium', 'pending', NOW(), NOW()),

-- Work tasks
(@shafa_id, @work_id, 'Team Meeting', 'Discuss project milestones', '2025-01-07 10:00:00', 'high', 'pending', NOW(), NOW()),
(@shafa_id, @work_id, 'Prepare Report', 'Prepare monthly report for management', '2025-01-07 13:00:00', 'high', 'pending', NOW(), NOW()),

-- Study tasks
(@shafa_id, @study_id, 'Read Chapter 3', 'Read and summarize chapter 3 of the textbook', '2025-01-07 09:00:00', 'medium', 'pending', NOW(), NOW()),
(@shafa_id, @study_id, 'Practice Problems', 'Solve 10 practice problems', '2025-01-07 16:00:00', 'medium', 'pending', NOW(), NOW()),

-- Personal project tasks
(@shafa_id, @personal_id, 'Gym Session', 'Leg day workout', '2025-01-07 08:00:00', 'medium', 'pending', NOW(), NOW()),
(@shafa_id, @personal_id, 'Meditation', '15-minute meditation session', '2025-01-07 18:30:00', 'low', 'pending', NOW(), NOW()),

-- Social life tasks
(@shafa_id, @social_id, 'Dinner with Friends', 'Meet friends at the restaurant', '2025-01-07 21:00:00', 'medium', 'pending', NOW(), NOW()),
(@shafa_id, @social_id, 'Movie Night', 'Watch a movie with family', '2025-01-07 22:00:00', 'low', 'pending', NOW(), NOW()),

-- Home tasks
(@shafa_id, @home_id, 'Clean Living Room', 'Vacuum and dust the living room', '2025-01-07 10:00:00', 'medium', 'pending', NOW(), NOW()),
(@shafa_id, @home_id, 'Grocery Shopping', 'Buy groceries for the week', '2025-01-07 13:00:00', 'high', 'pending', NOW(), NOW());
