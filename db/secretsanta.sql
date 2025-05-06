CREATE TABLE execution (
                           id INT PRIMARY KEY,
                           algo_executed BOOLEAN DEFAULT FALSE,
                           last_executed DATETIME NULL,
                           status VARCHAR(20) DEFAULT 'pending'
);

INSERT INTO execution (id, algo_executed, status) VALUES (1, FALSE, 'pending');



UPDATE execution
SET status = 'pending',
    last_executed = NULL,
    algo_executed = 0
WHERE id = 1;





CREATE TABLE participants (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              prenom VARCHAR(100) NOT NULL,
                              email VARCHAR(100) NOT NULL UNIQUE,
                              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE participants ADD UNIQUE (email);
