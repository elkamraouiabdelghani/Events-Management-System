-- Event Management System Database Schema
-- Generated from Laravel Migrations

-- Drop tables if they exist (in reverse order to avoid foreign key constraints)
DROP TABLE IF EXISTS failed_jobs;
DROP TABLE IF EXISTS job_batches;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS cache_locks;
DROP TABLE IF EXISTS cache;
DROP TABLE IF EXISTS canceled_events;
DROP TABLE IF EXISTS organizer_historics;
DROP TABLE IF EXISTS event_versions;
DROP TABLE IF EXISTS event_stats;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS organizers;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS regions;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS password_reset_tokens;
DROP TABLE IF EXISTS users;

-- =====================================================
-- 1. USERS AND AUTHENTICATION TABLES
-- =====================================================

-- Users table
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'organizer') NOT NULL,
    status ENUM('active', 'deactive') NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Password reset tokens table
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- Sessions table
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

-- =====================================================
-- 2. CACHE AND QUEUE TABLES
-- =====================================================

-- Cache table
CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL
);

-- Cache locks table
CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);

-- Jobs table
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
);

-- Job batches table
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
);

-- Failed jobs table
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- 3. APPLICATION TABLES
-- =====================================================

-- Categories table
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Regions table
CREATE TABLE regions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Cities table
CREATE TABLE cities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    region_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
);

-- Organizers table
CREATE TABLE organizers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    title VARCHAR(255) NULL,
    description VARCHAR(255) NULL,
    phone_numbre VARCHAR(10) NULL,
    image VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Events table
CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organizer_id BIGINT UNSIGNED NULL,
    organizer_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    region_id BIGINT UNSIGNED NOT NULL,
    city_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    place VARCHAR(255) NOT NULL,
    image VARCHAR(255) NULL,
    status ENUM('new', 'updated', 'publish', 'canceled', 'passed') NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (organizer_id) REFERENCES organizers(id) ON DELETE CASCADE,
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Event stats table
CREATE TABLE event_stats (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    views INT DEFAULT 0,
    interestings INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Event versions table
CREATE TABLE event_versions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    version VARCHAR(255) NOT NULL,
    organizer_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    region_id BIGINT UNSIGNED NOT NULL,
    city_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    place VARCHAR(255) NOT NULL,
    image VARCHAR(255) NULL,
    status VARCHAR(255) DEFAULT 'updated',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (organizer_id) REFERENCES organizers(id) ON DELETE CASCADE,
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Organizer historics table
CREATE TABLE organizer_historics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organizer_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    region_id BIGINT UNSIGNED NOT NULL,
    city_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    place VARCHAR(255) NOT NULL,
    image VARCHAR(255) NULL,
    status VARCHAR(255) DEFAULT 'passed',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (organizer_id) REFERENCES organizers(id) ON DELETE CASCADE,
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Canceled events table
CREATE TABLE canceled_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organizer_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    region_id BIGINT UNSIGNED NOT NULL,
    city_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    place VARCHAR(255) NOT NULL,
    image VARCHAR(255) NULL,
    status VARCHAR(255) DEFAULT 'canceled',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (organizer_id) REFERENCES organizers(id) ON DELETE CASCADE,
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- =====================================================
-- INDEXES FOR BETTER PERFORMANCE
-- =====================================================

-- Add indexes for better query performance
CREATE INDEX idx_events_date ON events(date);
CREATE INDEX idx_events_status ON events(status);
CREATE INDEX idx_events_organizer_id ON events(organizer_id);
CREATE INDEX idx_events_category_id ON events(category_id);
CREATE INDEX idx_events_region_id ON events(region_id);
CREATE INDEX idx_events_city_id ON events(city_id);

CREATE INDEX idx_event_stats_event_id ON event_stats(event_id);
CREATE INDEX idx_event_versions_event_id ON event_versions(event_id);
CREATE INDEX idx_organizer_historics_organizer_id ON organizer_historics(organizer_id);
CREATE INDEX idx_canceled_events_organizer_id ON canceled_events(organizer_id);

CREATE INDEX idx_cities_region_id ON cities(region_id);
CREATE INDEX idx_organizers_user_id ON organizers(user_id);

-- =====================================================
-- SAMPLE DATA (OPTIONAL)
-- =====================================================

-- Insert sample categories
INSERT INTO categories (name, created_at, updated_at) VALUES
('Music', NOW(), NOW()),
('Sports', NOW(), NOW()),
('Technology', NOW(), NOW()),
('Business', NOW(), NOW()),
('Education', NOW(), NOW());

-- Insert sample regions
INSERT INTO regions (name, created_at, updated_at) VALUES
('North Region', NOW(), NOW()),
('South Region', NOW(), NOW()),
('East Region', NOW(), NOW()),
('West Region', NOW(), NOW()),
('Central Region', NOW(), NOW());

-- Insert sample cities
INSERT INTO cities (name, region_id, created_at, updated_at) VALUES
('City A', 1, NOW(), NOW()),
('City B', 1, NOW(), NOW()),
('City C', 2, NOW(), NOW()),
('City D', 2, NOW(), NOW()),
('City E', 3, NOW(), NOW());

-- Insert sample admin user
INSERT INTO users (name, role, status, email, password, created_at, updated_at) VALUES
('Admin User', 'admin', 'active', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Insert sample organizer
INSERT INTO users (name, role, status, email, password, created_at, updated_at) VALUES
('Organizer User', 'organizer', 'active', 'organizer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Insert sample organizer profile
INSERT INTO organizers (user_id, title, description, phone_numbre, created_at, updated_at) VALUES
(2, 'Sample Organizer', 'A sample event organizer', '1234567890', NOW(), NOW()); 