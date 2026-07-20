<?php

$dbFile = __DIR__ . '/writable/database.db';
if (!is_dir(__DIR__ . '/writable')) {
    mkdir(__DIR__ . '/writable', 0777, true);
}

$db = new SQLite3($dbFile);
$db->exec('PRAGMA foreign_keys = ON;');

$db->exec('DROP TABLE IF EXISTS transaction_detail;');
$db->exec('DROP TABLE IF EXISTS transaction_mm;');
$db->exec('DROP TABLE IF EXISTS bareme_frais;');
$db->exec('DROP TABLE IF EXISTS type_operation;');
$db->exec('DROP TABLE IF EXISTS utilisateur;');
$db->exec('DROP TABLE IF EXISTS type_utilisateur;');
$db->exec('DROP TABLE IF EXISTS prefixe;');
$db->exec('DROP TABLE IF EXISTS operateur;');
$db->exec('DROP TABLE IF EXISTS parametre;');
$db->exec('DROP TABLE IF EXISTS migrations;');

$db->exec('CREATE TABLE operateur (id INTEGER PRIMARY KEY AUTOINCREMENT, nom TEXT UNIQUE NOT NULL);');
$db->exec('CREATE TABLE prefixe (id INTEGER PRIMARY KEY AUTOINCREMENT, prefixe TEXT UNIQUE NOT NULL, operateur_id INTEGER NOT NULL, FOREIGN KEY (operateur_id) REFERENCES operateur(id));');
$db->exec('CREATE TABLE type_utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT, nom TEXT UNIQUE NOT NULL);');
$db->exec('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT, telephone TEXT UNIQUE NOT NULL, solde REAL DEFAULT 0, type_utilisateur_id INTEGER NOT NULL, FOREIGN KEY (type_utilisateur_id) REFERENCES type_utilisateur(id));');
$db->exec('CREATE TABLE type_operation (id INTEGER PRIMARY KEY AUTOINCREMENT, nom TEXT UNIQUE NOT NULL);');
$db->exec('CREATE TABLE bareme_frais (id INTEGER PRIMARY KEY AUTOINCREMENT, type_operation_id INTEGER NOT NULL, montant_min REAL NOT NULL, montant_max REAL NOT NULL, frais REAL NOT NULL, FOREIGN KEY (type_operation_id) REFERENCES type_operation(id));');
$db->exec('CREATE TABLE transaction_mm (id INTEGER PRIMARY KEY AUTOINCREMENT, type_operation_id INTEGER NOT NULL, expediteur INTEGER, recepteur INTEGER, montant REAL NOT NULL, frais REAL DEFAULT 0, frais_retrait REAL DEFAULT 0, commission REAL DEFAULT 0, inclure_frais_retrait INTEGER DEFAULT 0, date_operation DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (type_operation_id) REFERENCES type_operation(id), FOREIGN KEY (expediteur) REFERENCES utilisateur(id), FOREIGN KEY (recepteur) REFERENCES utilisateur(id));');
$db->exec('CREATE TABLE transaction_detail (id INTEGER PRIMARY KEY AUTOINCREMENT, transaction_id INTEGER NOT NULL, destinataire INTEGER NOT NULL, montant REAL NOT NULL, FOREIGN KEY (transaction_id) REFERENCES transaction_mm(id));');
$db->exec('CREATE TABLE parametre (cle TEXT PRIMARY KEY, valeur TEXT NOT NULL);');
$db->exec('CREATE TABLE migrations (id INTEGER PRIMARY KEY AUTOINCREMENT, version VARCHAR NOT NULL, class VARCHAR NOT NULL, "group" VARCHAR NOT NULL, namespace VARCHAR NOT NULL, time INT NOT NULL, batch INT NOT NULL);');

$db->exec("INSERT INTO operateur(nom) VALUES ('yas'), ('autre operateur');");
$db->exec("INSERT INTO prefixe(prefixe, operateur_id) VALUES ('034', 1), ('038', 1);");
$db->exec("INSERT INTO type_utilisateur(nom) VALUES ('ADMIN'), ('CLIENT');");
$db->exec("INSERT INTO utilisateur(telephone, solde, type_utilisateur_id) VALUES ('0000000000', 0, 1);");
$db->exec("INSERT INTO type_operation(nom) VALUES ('Depot'), ('Retrait'), ('Transfert');");
$db->exec("INSERT INTO bareme_frais(type_operation_id, montant_min, montant_max, frais) VALUES
    (2, 100, 1000, 50),
    (2, 1001, 5000, 50),
    (2, 5001, 10000, 100),
    (2, 10001, 25000, 200),
    (2, 25001, 50000, 400),
    (2, 50001, 100000, 800),
    (2, 100001, 250000, 1500),
    (2, 250001, 500000, 2500),
    (2, 500001, 1000000, 2500),
    (2, 1000001, 2000000, 3000),
    (3, 100, 1000, 50),
    (3, 1001, 5000, 50),
    (3, 5001, 10000, 100),
    (3, 10001, 25000, 200),
    (3, 25001, 50000, 400),
    (3, 50001, 100000, 800),
    (3, 100001, 250000, 1500),
    (3, 250001, 500000, 2500),
    (3, 500001, 1000000, 2500),
    (3, 1000001, 2000000, 3000);");
$db->exec("INSERT INTO parametre(cle, valeur) VALUES ('commission_transfert_inter_operateur', '2.5');");
$time = time();
$db->exec("INSERT INTO migrations(version, class, `group`, namespace, time, batch) VALUES
    ('20240101000001', 'App\\\\Database\\\\Migrations\\\\CreateOperateurTable', 'default', 'App', $time, 1),
    ('20240101000002', 'App\\\\Database\\\\Migrations\\\\CreatePrefixeTable', 'default', 'App', $time, 1),
    ('20240101000003', 'App\\\\Database\\\\Migrations\\\\CreateTypeUtilisateurTable', 'default', 'App', $time, 1),
    ('20240101000004', 'App\\\\Database\\\\Migrations\\\\CreateUtilisateurTable', 'default', 'App', $time, 1),
    ('20240101000005', 'App\\\\Database\\\\Migrations\\\\CreateTypeOperationTable', 'default', 'App', $time, 1),
    ('20240101000006', 'App\\\\Database\\\\Migrations\\\\CreateBaremeFraisTable', 'default', 'App', $time, 1),
    ('20240101000007', 'App\\\\Database\\\\Migrations\\\\CreateTransactionMmTable', 'default', 'App', $time, 1),
    ('20240101000008', 'App\\\\Database\\\\Migrations\\\\CreateViews', 'default', 'App', $time, 1),
    ('20240101000009', 'App\\\\Database\\\\Migrations\\\\CreateParametreTable', 'default', 'App', $time, 1);");

$db->exec('CREATE VIEW v_gain_operateur AS SELECT SUM(frais) AS gain_total FROM transaction_mm;');
$db->exec('CREATE VIEW v_situation_client AS SELECT id, telephone, solde FROM utilisateur WHERE type_utilisateur_id = 2;');

echo "Base de donnees reinitialisee avec succes dans : $dbFile\n";
