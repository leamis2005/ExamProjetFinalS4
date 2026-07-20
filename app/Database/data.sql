-- db_name: produit

USE produit;

CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL
);

INSERT INTO produits (nom, prix) VALUES ('Produit A', 19.99), ('Produit B', 29.99), ('Produit C', 39.99);