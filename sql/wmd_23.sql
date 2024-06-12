DROP DATABASE IF EXISTS wmd_23;
CREATE DATABASE wmd_23;
USE wmd_23;

-- Création de la table Catégories_Donnation
CREATE TABLE Cate_Don (
    id_catedon INT AUTO_INCREMENT,
    Nom_Cate_Don VARCHAR(255),
    Descrip_Cate_Don VARCHAR(255),
    PRIMARY KEY (id_catedon)
);

-- Création de la table CategoriesProjets
CREATE TABLE Cate_Projets (
    id_cateproj INT AUTO_INCREMENT,
    Nom_Cate_Proj VARCHAR(255),
    Descrip_Cate_Proj VARCHAR(255),
    PRIMARY KEY (id_cateproj)
);

-- Création de la table AssociationCaritatif 
CREATE TABLE Asso_Carita (
    id_assocarita INT AUTO_INCREMENT,
    Nom_Asso_Carita VARCHAR(255),
    Descrip_Asso_Carita VARCHAR(255),
    Pays_Asso_Carita VARCHAR(255),
    Adresse_Asso_Carita VARCHAR(255),
    Email_Asso_Carita VARCHAR(255),
    Objectif_Asso_Carita TEXT(2000),
    PRIMARY KEY (id_assocarita)
);

-- Création de la table ProjetsCaritatifs
CREATE TABLE Projets_Carita (
    id_projetcar INT AUTO_INCREMENT,
    Titre_P_Car VARCHAR(255),
    Descrip_P_Car VARCHAR(255),
    Date_Debut_P_Car DATE,
    Date_Fin_P_Car DATE,
    id_assocarita INT,
    id_cateproj INT,
    status ENUM('Valide', 'En cours', 'Refuse', 'Favoris'),
    PRIMARY KEY (id_projetcar),
    FOREIGN KEY (id_assocarita) REFERENCES Asso_Carita(id_assocarita),
    FOREIGN KEY (id_cateproj) REFERENCES Cate_Projets(id_cateproj)
);

-- Création de la table Image_P
CREATE TABLE Images_P (
    id_imagep INT AUTO_INCREMENT,
    Nom_Image_P VARCHAR(255),
    Chemin_Image_P VARCHAR(255),
    id_projetcar INT,
    PRIMARY KEY (id_imagep),
    FOREIGN KEY (id_projetcar) REFERENCES Projets_Carita(id_projetcar)
);

-- Ajout de la clé étrangère id_imagep à la table Projets_Carita
ALTER TABLE Projets_Carita
ADD COLUMN id_imagep INT,
ADD CONSTRAINT fk_id_imagep FOREIGN KEY (id_imagep) REFERENCES Images_P(id_imagep);

-- Création de la table Roles
CREATE TABLE Roles (
    id_role INT AUTO_INCREMENT,
    Nom_Role VARCHAR(255),
    PRIMARY KEY (id_role),
    UNIQUE (id_role)
);

-- Création de la table Utilisateurs
CREATE TABLE Utilisateurs (
    id_utilisateur INT AUTO_INCREMENT,
    Nom VARCHAR(255),
    Prenom VARCHAR(255),
    Email VARCHAR(255),
    Age INT(3),
    Mdp_Utilisateur VARCHAR(255),
    Telephone INT(3),
    Date_Inscription DATE,
    id_role INT,
    PRIMARY KEY (id_utilisateur),
    FOREIGN KEY (id_role) REFERENCES Roles(id_role),
    UNIQUE (Email),
    UNIQUE (Telephone)
);

-- Création de la table Evenements
CREATE TABLE Evenements (
    id_evenement INT AUTO_INCREMENT,
    Nom_Event VARCHAR(255),
    Descrip_Event VARCHAR(255),
    Date_Debut_Event DATE,
    Date_Fin_Event DATE,
    Lieu_Event VARCHAR(255),
    id_assocarita INT,
    id_imagep INT,
    PRIMARY KEY (id_evenement),
    FOREIGN KEY (id_assocarita) REFERENCES Asso_Carita(id_assocarita),
    FOREIGN KEY (id_imagep) REFERENCES Images_P(id_imagep)
);

-- Création de la table Séjours
CREATE TABLE Sejours (
    id_sejour INT AUTO_INCREMENT,
    Date_Debut_Sejour DATE,
    Nb_Places_Dispo_Sejour INT,
    Station_Sejour VARCHAR(255),
    Prix_Sejour DECIMAL(10, 2),
    PRIMARY KEY (id_sejour)
);

-- Création de la table Evaluations
CREATE TABLE Evaluations (
    id_evaluation INT AUTO_INCREMENT,
    id_sejour INT,
    Note INT NOT NULL,
    Commentaire VARCHAR(255) NOT NULL,
    Date_Evaluation DATE,
    PRIMARY KEY (id_evaluation),
    FOREIGN KEY (id_sejour) REFERENCES Sejours(id_sejour)
);

-- Création de la table Reservations
CREATE TABLE Reservations (
    id_reservation INT AUTO_INCREMENT,
    id_sejour INT,
    id_utilisateur INT,
    Date_Reservation DATE,
    Nb_Personne INT,
    PRIMARY KEY (id_reservation),
    FOREIGN KEY (id_sejour) REFERENCES Sejours(id_sejour),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur)
);

-- Création de la table Donnations
CREATE TABLE Donnations (
    id_donnation INT AUTO_INCREMENT,
    Montant_Don DECIMAL(10, 2),
    Date_Don DATE,
    id_utilisateur INT,
    id_projetcar INT,
    id_catedon INT,
    id_imagep INT,
    PRIMARY KEY (id_donnation),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur),
    FOREIGN KEY (id_projetcar) REFERENCES Projets_Carita(id_projetcar),
    FOREIGN KEY (id_catedon) REFERENCES Cate_Don(id_catedon),
    FOREIGN KEY (id_imagep) REFERENCES Images_P(id_imagep)
);

-- Création de la table Paiements
CREATE TABLE Paiements (
    id_paiement INT AUTO_INCREMENT,
    Montant_Paie DECIMAL(10, 2),
    Date_Paie DATE,
    id_utilisateur INT,
    id_donnation INT,
    Mode_Paie VARCHAR(255),
    Stat_Paie VARCHAR(255),
    Ref_Paie VARCHAR(255),
    PRIMARY KEY (id_paiement),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur),
    FOREIGN KEY (id_donnation) REFERENCES Donnations(id_donnation)
);

-- Création de la table Activités
CREATE TABLE Activites (
    id_activite INT AUTO_INCREMENT,
    Libelle_Activite VARCHAR(255),
    Nom_Station_Activite VARCHAR(255),
    Prix_Activite DECIMAL(10, 2),
    PRIMARY KEY (id_activite)
);

-- Création de la table Admin (la table enfant)
CREATE TABLE Admin (
    id_admin INT AUTO_INCREMENT,
    id_utilisateur INT,
    PRIMARY KEY (id_admin),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur)
);

-- Création de la table Responsable (la table enfant)
CREATE TABLE Responsable (
    id_responsable INT AUTO_INCREMENT,
    id_assocarita INT,
    id_utilisateur INT,
    PRIMARY KEY (id_responsable),
    FOREIGN KEY (id_assocarita) REFERENCES Asso_Carita(id_assocarita),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur)
);

-- Triggers pour vérifier l'unicité de l'email
DELIMITER //

CREATE TRIGGER before_user_insert_email
BEFORE INSERT ON Utilisateurs
FOR EACH ROW
BEGIN
    DECLARE email_count INT;

    SELECT COUNT(*) INTO email_count
    FROM Utilisateurs
    WHERE Email = NEW.Email;

    IF email_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'L''email existe déjà.';
    END IF;
END//

DELIMITER ;

-- Triggers pour vérifier l'unicité du téléphone
DELIMITER //

CREATE TRIGGER before_user_insert_telephone
BEFORE INSERT ON Utilisateurs
FOR EACH ROW
BEGIN
    DECLARE telephone_count INT;

    SELECT COUNT(*) INTO telephone_count
    FROM Utilisateurs
    WHERE Telephone = NEW.Telephone;

    IF telephone_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le téléphone existe déjà.';
    END IF;
END//

DELIMITER ;
