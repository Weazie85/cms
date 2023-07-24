-- Create the database
CREATE DATABASE IF NOT EXISTS cms;
USE cms;

-- Create the 'clients' table
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    client_code VARCHAR(6) NOT NULL,
    UNIQUE KEY uk_client_code (client_code)
);

-- Create the 'contacts' table
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL,
    UNIQUE KEY uk_email (email)
);

-- Create the 'client_contacts' table to establish the many-to-many relationship
CREATE TABLE IF NOT EXISTS client_contacts (
    client_id INT NOT NULL,
    contact_id INT NOT NULL,
    PRIMARY KEY (client_id, contact_id),
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE
);

-- Create a stored procedure to create a client
DELIMITER //

CREATE PROCEDURE create_client(
    IN input_name VARCHAR(50)
)
BEGIN
    DECLARE alpha_code CHAR(3);
    DECLARE numeric_code INT;
    DECLARE tmp_client_code VARCHAR(6);
    DECLARE unique_code_found BOOLEAN DEFAULT FALSE;

    -- Generate the client code
    SET alpha_code = LEFT(UPPER(input_name), 3);

    -- Check if the client name is shorter than 3 characters
    IF CHAR_LENGTH(alpha_code) < 3 THEN
        SET alpha_code = CONCAT(alpha_code, CHAR(65 + (SELECT COUNT(*) FROM clients WHERE client_code LIKE CONCAT(alpha_code, '%'))));
    END IF;

    -- Generate a unique numeric code
    SET numeric_code = 1;
    WHILE unique_code_found = FALSE 
    DO
        SET tmp_client_code = CONCAT(alpha_code, LPAD(numeric_code, 3, '0'));
        IF (SELECT COUNT(*) FROM clients WHERE client_code = tmp_client_code) = 0 THEN
            SET unique_code_found = TRUE;
        ELSE
            SET numeric_code = numeric_code + 1;
        END IF;
    END WHILE;

    -- Insert the client into the 'clients' table
    INSERT INTO clients (name, client_code) VALUES (input_name, tmp_client_code);
     
END

DELIMITER ;

-- Create a stored procedure to create a contact
DELIMITER //

CREATE PROCEDURE create_contact(
    IN input_name VARCHAR(30),
    IN input_surname VARCHAR(30),
    IN input_email VARCHAR(100),
    OUT output_contact_id INT
)
BEGIN
    -- Insert the contact into the 'contacts' table
    INSERT INTO contacts (name, surname, email) VALUES (input_name, input_surname, input_email);
    SET output_contact_id = LAST_INSERT_ID();
END //

DELIMITER ;

-- Create a stored procedure to link a contact to a client
DELIMITER //

CREATE PROCEDURE link_contact_to_client(
    IN input_client_id INT,
    IN input_contact_id INT
)
BEGIN
    -- Insert the relationship into the 'client_contacts' table
    INSERT INTO client_contacts (client_id, contact_id) VALUES (input_client_id, input_contact_id);
END //

DELIMITER ;

-- Create a stored procedure to unlink a contact from a client
DELIMITER //

CREATE PROCEDURE unlink_contact_from_client(
    IN input_client_id INT,
    IN input_contact_id INT
)
BEGIN
    -- Delete the relationship from the 'client_contacts' table
    DELETE FROM client_contacts WHERE client_id = input_client_id AND contact_id = input_contact_id;
END //

DELIMITER ;

-- create a stored procedure to view all clients 
DELIMITER //

CREATE PROCEDURE get_clients()
BEGIN
    SELECT
		c.id,
        c.name,
		c.client_code,
		(SELECT COUNT(*) FROM client_contacts cc WHERE cc.client_id = c.id) AS num_contacts
	FROM
		clients c
    ORDER BY c.name ASC;
END //

DELIMITER ;

-- create a stored procedure to view client contacts
DELIMITER //

CREATE PROCEDURE get_client_contacts(IN input_client_id INT)
BEGIN
    SELECT cc.client_id, cc.contact_id, CONCAT(c.name, " ", c.surname) AS name, c.email
    FROM contacts c
    INNER JOIN client_contacts cc ON c.id = cc.contact_id
    WHERE cc.client_id = input_client_id
    ORDER BY CONCAT(c.name, " ", c.surname);
END //

DELIMITER ;

-- create a procedure to view contacts
DELIMITER //

CREATE PROCEDURE get_contacts()
BEGIN
    SELECT
		c.id,
        c.name,
        c.surname,
		c.email,
		(SELECT COUNT(*) FROM client_contacts cc WHERE cc.contact_id = c.id) AS num_clients
	FROM
		contacts c
    ORDER BY CONCAT(c.name, " ", c.surname);
END //

DELIMITER ;

-- create a procedure to check if a email has been used

DELIMITER //
CREATE PROCEDURE check_contact_by_email(IN user_email VARCHAR(100))
BEGIN
    -- Check if a contact exists with the given email address
    SELECT *
    FROM contacts
    WHERE email = user_email;
END //

DELIMITER ;

-- Create procedure to check contact IDs
DELIMITER //

CREATE PROCEDURE check_contact_client_id (
    IN input_client_id INT,
    IN input_contact_id INT
)
BEGIN
    -- Insert the relationship into the 'client_contacts' table
    SELECT * 
    FROM client_contacts
    WHERE client_contacts.client_id = input_client_id
      AND client_contacts.contact_id = input_contact_id
    LIMIT 1;
    
END //

DELIMITER ;