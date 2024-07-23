
-- Create the emergency_waitlist database
CREATE DATABASE emergency_waitlist;

-- Connect to the emergency_waitlist database
\c emergency_waitlist

-- Create the administrator table
CREATE TABLE IF NOT EXISTS administrator (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255)
);

-- Create the patients table
CREATE TABLE IF NOT EXISTS patients (
    code VARCHAR(3) PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    check_in TIME NOT NULL,
    severity INT, 
    wait_time DOUBLE PRECISION DEFAULT 0,
    status VARCHAR(50) DEFAULT 'waiting'
);

-- Insert an admin user
INSERT INTO administrator (username, password) VALUES ('admin_user', 'password'); 

-- Create a function to calculate wait times for all patients
CREATE OR REPLACE FUNCTION recalculate_wait_times()
RETURNS VOID AS $$
DECLARE
    rec RECORD;
BEGIN
    -- Disable triggers
    PERFORM pg_catalog.set_config('session_replication_role', 'replica', true);

    FOR rec IN (SELECT * FROM patients WHERE status = 'waiting' ORDER BY check_in) LOOP
        UPDATE patients
        SET wait_time = (
            SELECT COALESCE(SUM(10 * severity), 0)
            FROM patients
            WHERE check_in < rec.check_in AND status = 'waiting'
        )
        WHERE code = rec.code;
    END LOOP;

    -- Re-enable triggers
    PERFORM pg_catalog.set_config('session_replication_role', 'origin', true);
END;
$$ LANGUAGE plpgsql;

-- Create a trigger function
CREATE OR REPLACE FUNCTION trigger_recalculate_wait_times()
RETURNS TRIGGER AS $$
BEGIN
    PERFORM recalculate_wait_times();
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

-- Trigger for INSERT operation
CREATE TRIGGER recalculate_wait_times_after_insert
AFTER INSERT ON patients
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_recalculate_wait_times();

-- Trigger for DELETE operation
CREATE TRIGGER recalculate_wait_times_after_delete
AFTER DELETE ON patients
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_recalculate_wait_times();

-- Trigger for UPDATE operation
CREATE TRIGGER recalculate_wait_times_after_update
AFTER UPDATE ON patients
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_recalculate_wait_times();

-- Insert some patients
INSERT INTO patients (code, first_name, last_name, check_in, severity) VALUES 
('A01', 'John', 'Doe', '09:00:00', 3),
('A02', 'Jane', 'Smith', '09:05:00', 2),
('A03', 'Alice', 'Johnson', '09:10:00', 1),
('A04', 'Bob', 'Brown', '09:15:00', 4);