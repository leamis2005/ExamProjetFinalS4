CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL
);

CREATE TABLE prefixe (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT UNIQUE NOT NULL,
    operateur_id INTEGER,
    FOREIGN KEY(operateur_id) REFERENCES operateur(id)
);

CREATE TABLE client (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT UNIQUE NOT NULL,
    nom TEXT,
    solde REAL DEFAULT 0
);

CREATE TABLE type_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT UNIQUE
);

CREATE TABLE bareme_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER,
    montant_min REAL,
    montant_max REAL,
    frais REAL,
    FOREIGN KEY(type_operation_id)
        REFERENCES type_operation(id)
);

CREATE TABLE transaction_mm (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER,
    expediteur INTEGER,
    recepteur INTEGER,
    montant REAL,
    frais REAL,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(type_operation_id)
        REFERENCES type_operation(id),
    FOREIGN KEY(expediteur)
        REFERENCES client(id),
    FOREIGN KEY(recepteur)
        REFERENCES client(id)
);

INSERT INTO bareme_frais(type_operation_id,montant_min,montant_max,frais)
VALUES
(2,100,1000,50),
(2,1001,5000,50),
(2,5001,10000,100),
(2,10001,25000,200),
(2,25001,50000,400),
(2,50001,100000,800),
(2,100001,250000,1500),
(2,250001,500000,2500),
(2,500001,1000000,2500),
(2,1000001,2000000,3000);

INSERT INTO type_operation(nom)
VALUES
('Depot'),
('Retrait'),
('Transfert');

INSERT INTO prefixe(prefixe,operateur_id)
VALUES
('033',2),
('037',2);

INSERT INTO operateur(nom)
VALUES ('Orange'),
('Airtel'),
('Telma');

CREATE VIEW v_gain_operateur AS
SELECT
SUM(frais) AS gain_total
FROM transaction_mm;

CREATE VIEW v_situation_client AS
SELECT
telephone,
nom,
solde
FROM client;