create database GASTRONOMIA;
use GASTRONOMIA;

create table UTENTE (
  IdUtente int auto_increment not null,
  NomeUtente varchar(50) not null,
  CognomeUtente varchar(50) not null,
  EmailUtente varchar(50) not null,
  PasswordUtente varchar(50) not null,
  TipoUtente varchar(1) not null,
  UltimaModifica datetime default null,
  primary key(IdUtente)
)ENGINE = InnoDB;

create table TIPO (
  IdTipo int auto_increment not null,
  NomeTipo varchar(40) not null,
  primary key (IdTipo)
)ENGINE = InnoDB;

insert into TIPO (NomeTipo) values
  ("Primi Piatti"),
  ("Secondi Piatti di Carne"),
  ("Secondi Piatti di Pesce"),
  ("Contorni");

create table PIATTO (
  IdPiatto int auto_increment not null,
  NomePiatto varchar(70) not null,
  Descrizione varchar(200),
  IdT int not null,
  primary key (IdPiatto),
  foreign key (IdT) references TIPO (IdTipo)
)ENGINE = InnoDB;

insert into PIATTO (NomePiatto, Descrizione, IdT) values
  ("Pasticcio di carne", null, 1),
  ("Pasticcio di melanzane", null, 1),
  ("Pasticcio di radicchio e provola affumicata", null, 1),
  ("Pasticcio di asparago e culatello", null, 1),
  ("Pasticcio di carciofi e brie", null, 1),
  ("Paella", null, 1),
  ("Spaghetti alle vongole", null, 1),
  ("Spaghetti allo scoglio", null, 1),
  ("Trippa alla parmigiana", null, 2),
  ("Spezzatino di puledro", null, 2),
  ("Polpette di carne", null, 2),
  ("Vitello tonnato", null, 2),
  ("Roastbeef all'inglese", null, 2),
  ("Vitello arrosto", null, 2),
  ("Cosce di faraona all'aceto balsamico", null, 2),
  ("Coniglio arrosto", null, 2),
  ("Sarde e mazzancolle in saor", null, 3),
  ("Baccalà mantecato", null, 3),
  ("Baccalà alla vicentina", null, 3),
  ("Baccalà insalata", null, 3),
  ("Baccalà in umido", null, 3),
  ("Filetto di branzino con patate", null, 3),
  ("Filetto di orata alla mediterranea", null, 3),
  ("Frittura di pesce al momento", null, 3),
  ("Salmone gratinato", null, 3),
  ("Seppioline e calamaretti ripieni", null, 3),
  ("Insalata di mare", null, 3),
  ("Insalata di piovra con patate", null, 3),
  ("Insalata di seppia con verdure", null, 3),
  ("Branzino o orata ai ferri", null, 3),
  ("Verdura cotta salvata in padella", null, 4),
  ("Patate al forno", null, 4),
  ("Peperonata", null, 4),
  ("Fagioli all'uccelletto", null, 4),
  ("Verdure grigliate", null, 4),
  ("Peperonata bianca al forno", null, 4);

create table PREFERENZA (
  IdU int not null,
  IdP int not null,
  primary key (IdU, IdP),
  foreign key (IdU) references UTENTE (IdUtente),
  foreign key (IdP) references PIATTO (IdPiatto)
)ENGINE = InnoDB;

create table CONVERSAZIONE (
  IdU int not null,
  TipoMessaggio varchar(10) not null,
  DataInvio datetime not null,
  TestoMessaggio varchar(1000) not null,
  primary key (IdU, TipoMessaggio, DataInvio),
  foreign key (IdU) references UTENTE (IdUtente)
)ENGINE = InnoDB;
