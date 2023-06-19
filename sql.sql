
create database	 db_bancodigital;

use db_bancodigital;

create table correntista(
id int not null auto_increment,
primary key(id),
nome varchar(45) not null,
cpf varchar(11) not null,
senha varchar(45) not null,
data_nasc date not null
);

create table conta(
id int not null auto_increment,
primary key(id),
tipo double not null,
saldo double not null,
limite varchar(45) not null,
id_correntista int not null,
foreign key(id_correntista) references correntista(id)
);

create table transacao(
id int not null auto_increment,
primary key(id),
data_trans char(50) not null,
valor char(200) not null,
id_conta_enviou int not null,
id_conta_recebeu int not null,
foreign key (id_conta_enviou) references conta(id),
foreign key(id_conta_recebeu) references conta(id)
);

create table chave_pix(
id int not null auto_increment,
primary key(id),
tipo double not null,
chave varchar(45) not null,
id_conta int not null,
foreign key(id_conta) references conta(id)
);