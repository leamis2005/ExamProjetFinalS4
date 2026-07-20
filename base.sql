CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL
);

CREATE TABLE prefixe (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT UNIQUE NOT NULL,
    operateur_id INTEGER NOT NULL,
    FOREIGN KEY (operateur_id) REFERENCES operateur(id)
);

CREATE TABLE type_utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT UNIQUE NOT NULL
);

CREATE TABLE utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT UNIQUE NOT NULL,
    solde REAL DEFAULT 0,
    type_utilisateur_id INTEGER NOT NULL,
    FOREIGN KEY (type_utilisateur_id) REFERENCES type_utilisateur(id)
);

CREATE TABLE type_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT UNIQUE NOT NULL
);

CREATE TABLE bareme_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    FOREIGN KEY (type_operation_id) REFERENCES type_operation(id)
);

CREATE TABLE transaction_mm (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    expediteur INTEGER,
    recepteur INTEGER,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (type_operation_id) REFERENCES type_operation(id),
    FOREIGN KEY (expediteur) REFERENCES utilisateur(id),
    FOREIGN KEY (recepteur) REFERENCES utilisateur(id)
);

CREATE TABLE commission (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pourcentage REAL NOT NULL
);

INSERT INTO commission(pourcentage)
VALUES (5);

INSERT INTO operateur(nom)
VALUES
('Orange'),
('Airtel'),
('Telma');

INSERT INTO prefixe(prefixe, operateur_id)
VALUES
('032',1),
('033',2),
('037',2),
('034',3),
('038',3);

INSERT INTO type_utilisateur(nom)
VALUES
('ADMIN'),
('CLIENT');

INSERT INTO utilisateur(telephone, solde, type_utilisateur_id)
VALUES
('0000000000',0,1);

INSERT INTO type_operation(nom)
VALUES
('Depot'),
('Retrait'),
('Transfert');

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
(2,1000001,2000000,3000),
(3,100,1000,50),
(3,1001,5000,50),
(3,5001,10000,100),
(3,10001,25000,200),
(3,25001,50000,400),
(3,50001,100000,800),
(3,100001,250000,1500),
(3,250001,500000,2500),
(3,500001,1000000,2500),
(3,1000001,2000000,3000);

CREATE VIEW v_gain_operateur AS
SELECT
    SUM(frais) AS gain_total
FROM transaction_mm;

CREATE VIEW v_situation_client AS
SELECT
    id,
    nom,
    telephone,
    solde
FROM utilisateur
WHERE type_utilisateur_id = 2;