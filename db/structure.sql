-- First you have too create a database 'users_db' in Postgress
-- CREATE DATABASE users_db;

--create users table
CREATE TABLE users (
    id serial NOT NULL,
    fullname character varying(150) NOT NULL,
    email character varying(150) NOT NULL,
    password character varying(15),
    PRIMARY KEY (id),
    UNIQUE (email)
);