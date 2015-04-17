CREATE TABLE customersweb 
(
 id_customer bigint AUTO_INCREMENT not null,
 firstname varchar(50) not null,
 lastname varchar(100) not null,
 username varchar (50) not null,
 email varchar(50) not null,
 phone varchar (20) not null,
 password varchar(100) not null,
 img_path varchar (200),
 mister boolean default true,
 PRIMARY KEY (email));
 
 
 CREATE TABLE team
 (
  id_team bigint AUTO_INCREMENT not null,
  name varchar(50) not null,
  id_category int not null,
  password varchar(100) not null,
  img_path varchar (200),
  id_sport int not null, 
  PRIMARY KEY (id_team),
  foreign key (id_category) REFERENCES category(id_category),
  foreign key (id_sport) REFERENCES sport(id_sport));
 
CREATE TABLE category
(
  id_category bigint AUTO_INCREMENT not null,
  name varchar(50) not null,
  PRIMARY KEY (id_category));
  
CREATE TABLE  customersweb_team(
	id_customer bigint not null,
	id_team bigint not null,
	PRIMARY KEY (id_customer, id_team),
	FOREIGN KEY (id_customer) REFERENCES customersweb(id_customer),
	FOREIGN KEY (id_team) REFERENCES team(id_team));

CREATE TABLE customersweb_players(
	id_customer bigint not null,
	position_id int not null,
	date_born date,
	dorsal int,
	PRIMARY KEY (id_customer),
	FOREIGN KEY (id_customer) REFERENCES customersweb(id_customer),
	FOREIGN KEY (position_id) REFERENCES player_position(position_id));

CREATE TABLE player_position(
  id_position int AUTO_INCREMENT not null,
  name varchar(50) not null,
  PRIMARY KEY (id_position));
 
 CREATE TABLE training_event(
  id_training bigint AUTO_INCREMENT not null,
  tittle varchar(100) not null,
  description text,
  place varchar(100),
  hour_training varchar(30),
  id_team bigint not null, 
  PRIMARY KEY (id_training),
  FOREIGN KEY (id_team) REFERENCES team(id_team));
  
CREATE TABLE  training_player(
    id_training_player bigint AUTO_INCREMENT not null,
	id_customer bigint not null,
	id_training bigint not null,
	PRIMARY KEY (id_training_player, id_customer, id_training),
	FOREIGN KEY (id_customer) REFERENCES customersweb(id_customer),
	FOREIGN KEY (id_training) REFERENCES training_event(id_training));
  
CREATE TABLE training_data(
	id_training_player bigint not null,
	start_time dateTime,
	end_time dateTime,
	calification int,
	PRIMARY KEY (id_training_player));

CREATE TABLE sport(
  id_sport int AUTO_INCREMENT not null,
  name varchar(50) not null,
  PRIMARY KEY (id_sport));	
  
  
  --Inserts Prueba
  insert into category (name) Values ('Senior');
insert into sport(name) Values ('Futbol');

INSERT INTO team (name, id_category, password, id_sport) VALUES ('Equipo1','1','123456','1');

insert customersweb_team  values (3, 1);
  