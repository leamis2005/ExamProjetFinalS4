# Taches

## Version 1

### Ismael

#### Backend
- Configuration de CodeIgniter 4.
- Configuration de la base de donnees SQLite.
- Conception de la base de donnees.
- Gestion des comptes clients.
- Implementation du login automatique avec le numero de telephone.
- Developpement de la fonctionnalite de depot.
- Consultation du solde du client.

#### Frontend
- Creation de la page de connexion.
- Developpement du tableau de bord client.
- Creation de la page de depot.
- Affichage du solde du client.

---

### Hiraina

#### Backend
- Configuration des prefixes de l'operateur.
- Gestion des types d'operations (depot, retrait, transfert).
- Gestion des baremes de frais.
- Developpement de la fonctionnalite de retrait.
- Developpement de la fonctionnalite de transfert.
- Gestion de l'historique des operations.
- Mise en place de la situation des gains de l'operateur.
- Mise en place de la situation des comptes clients.

#### Frontend
- Creation des pages d'administration.
- Interface de gestion des frais.
- Interface de gestion des prefixes.
- Developpement du tableau de bord operateur.
- Creation de la page de retrait.
- Creation de la page de transfert.
- Creation de la page d'historique.

## Version 2

### Ismael

#### Backend
- Ajout de l'option « Inclure les frais de retrait » lors d'un transfert entre clients du même opérateur.
- Validation qu'un envoi multiple est autorisé uniquement vers des numéros appartenant au même opérateur.
- Développement de l'envoi multiple avec répartition automatique du montant.
- Mise à jour du traitement des transactions selon les nouvelles règles.

#### Frontend
- Ajout de la case « Inclure les frais de retrait ».
- Développement de l'interface d'envoi multiple.
- Affichage des erreurs lorsque les numéros appartiennent à un autre opérateur.
- Affichage du récapitulatif de l'envoi.

---

### Hiraina

#### Backend
- Configuration des préfixes des autres opérateurs.
- Gestion des commissions supplémentaires (%) pour les transferts vers les autres opérateurs.
- Séparation des gains de l'opérateur et des autres opérateurs dans les statistiques.
- Calcul des montants à reverser à chaque opérateur.

#### Frontend
- Interface de gestion des préfixes des autres opérateurs.
- Interface de gestion des commissions.
- Mise à jour de la page « Situation des gains ».
- Création de la page « Situation des montants à envoyer à chaque opérateur ».