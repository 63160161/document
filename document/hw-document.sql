DROP DATABASE docdb;
CREATE DATABASE docdb;
USE docdb;

DROP TABLE IF EXISTS doc_staff;
DROP TABLE IF EXISTS  staff;
DROP TABLE IF EXISTS  documents;

CREATE TABLE staff ( 
  id INT PRIMARY KEY AUTO_INCREMENT , 
  stf_code VARCHAR(50) UNIQUE NOT NULL , 
  stf_name VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

INSERT INTO staff (id, stf_code, stf_name) VALUES (NULL, 's0001', 'วิทวัส พันธุมจินดา');

CREATE TABLE documents (
  id INT PRIMARY KEY AUTO_INCREMENT , 
  doc_num varchar(50) UNIQUE NOT NULL,
  doc_title varchar(1000) NOT NULL,
  doc_start_date date NOT NULL,
  doc_to_date date,
  doc_status varchar(10) NOT NULL,
  doc_file_name varchar(255)
) ENGINE=InnoDB;

CREATE TABLE doc_staff (
  doc_id int NOT NULL,
  stf_id int NOT NULL,
  PRIMARY KEY (doc_id,stf_id),
  FOREIGN KEY (doc_id) REFERENCES documents(id),
  FOREIGN KEY (stf_id) REFERENCES staff(id)
) ENGINE=InnoDB;