CREATE TABLE users
(
id SERIAL,
nom VARCHAR(15),
prenom VARCHAR(30), 
login VARCHAR(15), 
password VARCHAR(35),
avatar TEXT,
telephone VARCHAR(15),
email VARCHAR(30)
);
DROP TABLE users;
ALTER TABLE users ADD COLUMN email VARCHAR(30);