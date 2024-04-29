CREATE TABLE users (
    id serial PRIMARY KEY,
    name varchar,
    email varchar,
    password varchar,
    Date_Of_Birth DATE
);
ALTER TABLE users
ADD token varchar;
DROP TABLE messages;
CREATE TABLE messages(
    id serial PRIMARY KEY,
    user_id INT,
    message varchar,
    message_time TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)


select u.email,m.message from users u,messages m where u.id=m.user_id;

SELECT  u.email,m.message FROM users u INNER JOIN messages m ON u.id=m.user_id;
