CREATE TABLE IF NOT EXISTS public.administrator
(
    user_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    passw character varying(50) COLLATE pg_catalog."default",
    CONSTRAINT administrator_pkey PRIMARY KEY (user_name)
)

CREATE TABLE IF NOT EXISTS public.patients
(
    code character varying(3) COLLATE pg_catalog."default" NOT NULL,
    f_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    l_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    check_in time without time zone NOT NULL,
    wait_time double precision,
    CONSTRAINT patients_pkey PRIMARY KEY (code)
)