CREATE TABLE Plaignant(
    NumPlaignant int NOT NULL AUTO_INCREMENT,
    NomPlaignant varchar(70) NULL,
    AdressePlaignant varchar(70) NULL,
    EmailPlaignant varchar(70) NULL,
    TelPlaignant varchar(70) NULL,
    UsernamePlaignant varchar(70) NULL,
    PasswordPlaignant varchar(255) NULL,
    Anonyme int NOT NULL DEFAULT 0,

    PRIMARY KEY (NumPlaignant)
);
CREATE TABLE Plainte(
    NumPlainte int NOT NULL AUTO_INCREMENT,
    NumPlaignant int NOT NULL,
    DatePlainte date NOT NULL,
    ObjetPlainte varchar(70) NOT NULL,
    DescriptionPlainte varchar(700) NOT NULL,
    ModeEmission varchar(70) NOT NULL,

    PRIMARY KEY (NumPlainte),
    FOREIGN KEY (NumPlaignant) REFERENCES Plaignant(NumPlaignant)
);
CREATE TABLE Service(
    CodeService VARCHAR(20) NOT NULL,
    LibelleService varchar(70) NOT NULL,

    PRIMARY KEY (CodeService)
);
CREATE TABLE Transmission(
    CodeTransmission VARCHAR(20) NOT NULL,
    CodeService VARCHAR(20) NOT NULL,
    NumPlainte int NOT NULL,

    DateTransmission date NOT NULL,
    DateReception date,

    PRIMARY KEY (CodeTransmission),
    FOREIGN KEY (CodeService) REFERENCES Service(CodeService),
    FOREIGN KEY (NumPlainte) REFERENCES Plainte(NumPlainte)
);
CREATE TABLE Reponse(
    NumReponse int NOT NULL AUTO_INCREMENT,
    CodeTransmission VARCHAR(20) NOT NULL,    
    
    DateReponse date NOT NULL,
    ObjetReponse date NOT NULL,
    DescriptionReponse VARCHAR(700) NOT NULL,
    EmisePar VARCHAR(70) NOT NULL,

    PRIMARY KEY (NumReponse),
    FOREIGN KEY (CodeTransmission) REFERENCES Transmission(CodeTransmission)
);