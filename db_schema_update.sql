ALTER TABLE gym_registrations
ADD INDEX idx_birth_date (birth_date),
ADD INDEX idx_created_at (created_at);
