
CREATE TABLE IF NOT EXISTS public.administrator (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS public.patients (
    code VARCHAR(3) PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    check_in TIME NOT NULL,
    severity INT, 
    wait_time DOUBLE PRECISION
);
