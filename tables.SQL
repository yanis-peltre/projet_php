Create table role(
                     roleid int,
                     label varchar(50),
                     auth_level int
);

Create table user(
                     userid INT AUTO_INCREMENT,
                     username VARCHAR(20) UNIQUE NOT NULL,
                     password VARCHAR(256) NOT NULL,
                     roleid int,
                     PRIMARY KEY (userid),
                     foreign key (roleid) references role(roleid)
);

insert into role values (1, 'Utilisateur', 1);

