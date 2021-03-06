    DROP DATABASE IF EXISTS taskmanager;
    CREATE DATABASE taskmanager; 
    USE taskmanager;
    
    DROP TABLE IF EXISTS tasks_statistics;
    DROP TABLE IF EXISTS tasks;
    DROP TABLE IF EXISTS users;
    
    CREATE TABLE users(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(64) NOT NULL UNIQUE, 
        password VARCHAR(255),
        apikey VARCHAR(32),
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    
    CREATE TABLE tasks (
    id int(11) NOT NULL AUTO_INCREMENT,
    description varchar(500) NOT NULL,
    user_id INT NOT NULL, 
    PRIMARY KEY (id),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT tasks_userid_fk FOREIGN KEY (user_id) REFERENCES users(id)    
    );

    CREATE TABLE tasks_statistics(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        user_id INT NOT NULL, 
        create_counter INT DEFAULT 0, 
        read_counter INT  DEFAULT 0, 
        readall_counter INT  DEFAULT 0, 
        update_counter INT DEFAULT 0, 
        delete_counter INT DEFAULT 0,
        last_entry TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT stats_userid_fk FOREIGN KEY (user_id) REFERENCES users(id)
    );