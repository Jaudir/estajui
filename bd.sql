drop database if exists estajui;
create database estajui;

use estajui;

create table endereco(
	id int auto_increment primary key,
	logradouro varchar(50),
	bairro varchar(30),
	numero int,
	complemento varchar(10),
	cidade varchar(30),
	sala varchar(30),
	uf char(2),
	cep numeric(8)

);

create table empresa (
	cnpj numeric(14) primary key,
	nome varchar(40),
	razao_social varchar(100),
	telefone numeric(11),
	fax numeric(10),
	nregistro numeric(8), 
	conselhofiscal varchar(30), 
	endereco_id int,
	conveniada bool,
	foreign key(endereco_id) references endereco(id) on delete cascade
);

create table responsavel(
	email varchar(50) primary key,
	nome varchar(50),
	telefone numeric(11),
	cargo varchar(20),
	empresa_cnpj numeric(14),
	aprovado boolean,
	foreign key(empresa_cnpj) references empresa(cnpj)
);

create table supervisor(
	id int auto_increment primary key,
	nome varchar(50),
	cargo varchar(20),
	habilitacao varchar(100),
	empresa_cnpj numeric(14),
	foreign key(empresa_cnpj) references empresa(cnpj)
);

create table campus(
	cnpj numeric(14) primary key,
	telefone numeric(11),
	endereco_id int,
	foreign key(endereco_id) references endereco(id)
);

create table curso(
	id int auto_increment primary key,
	nome varchar(40)
);

create table status(
	codigo int auto_increment primary key,
	descricao varchar(170),
	bitmap_usuarios_alvos varchar(5) /* Aluno PO OE CE SRA*/
);

create table usuario(
	email varchar(50) primary key,
	senha varchar(256) NOT NULL,
	tipo int
);

create table funcionario(
	siape numeric(9) primary key,
	nome varchar(50),
	bool_po int, 
bool_oe int, 	
bool_ce int, 	
bool_sra int, 	
bool_root int,
	formacao varchar(100),
	privilegio int,
	usuario_email varchar(50),
	campus_cnpj numeric(14),
	foreign key(usuario_email) references usuario(email),
	foreign key(campus_cnpj) references campus(cnpj)
);

create table aluno(
	cpf numeric(11) primary key,
	nome varchar(50),
	data_nasc date,
	rg_num varchar(15),
	rg_orgao varchar(14),
	estado_civil varchar(10),
	sexo char(10),
	telefone numeric(11),
	celular numeric(11),
	nome_pai varchar(50),
	nome_mae varchar(50),
	cidade_natal varchar(30),
	estado_natal char(2),
	acesso int,
	usuario_email varchar(50),
	endereco_id int,
	foreign key(usuario_email) references usuario(email),
	foreign key(endereco_id) references endereco(id)
);

create table aluno_estuda_curso(
	matricula int unique primary key,
	semestre_inicio int,
	ano_inicio int,
	curso_id int,
	aluno_cpf numeric(11),
	foreign key(curso_id) references curso(id),
	foreign key(aluno_cpf) references aluno (cpf)
);

create table estagio(
	id int auto_increment primary key,
	bool_aprovado int,
	bool_obrigatorio int,
	periodo int,
	serie int,
	modulo int,
	integ_ano numeric(4),
	integ_semestre numeric(1),
	dependencias varchar(200),
	justificativa varchar(150),
	endereco_tc varchar(30),
	endereco_pe varchar(30),
	aluno_cpf numeric(11),
	empresa_cnpj numeric(14),
	curso_id int,
	po_siape numeric(9),
	status_codigo int,
	foreign key(po_siape) references funcionario(siape),
	foreign key(aluno_cpf ) references aluno(cpf),
	foreign key(empresa_cnpj) references empresa(cnpj),	
	foreign key(curso_id) references curso(id),
	foreign key(status_codigo) references status(codigo)
);

create table modifica_status(
    id int auto_increment primary key,
    data date,	
    estagio_id int,
    status_codigo int,
    usuario_email varchar(50),
    foreign key(estagio_id) references estagio(id),
    foreign key(status_codigo ) references status(codigo),
    foreign key(usuario_email) references usuario(email)	
);


create table notificacao(
	id int auto_increment primary key,
	lida char,
	temJustificativa bool,
	justificativa varchar(500),
	modifica_status_id int,
	foreign key(modifica_status_id) references modifica_status(id)
);

create table comentario_pe(
	id int auto_increment primary key,
	data date,
	descricao varchar(1000),
	endereco_correcao varchar(30),
	estagio_id int,
	po_siape numeric(9),
	foreign key(po_siape) references funcionario(siape),
	foreign key(estagio_id) references estagio(id)
);

create table plano_estagio(
	estagio_id int primary key, 
	data_assinatura date,
	atividades varchar(100),
	remuneracao real,
	vale_transporte real,
	data_ini date,
	data_fim date,
	hora_inicio1 timestamp default now(),
	hora_inicio2 timestamp default now(),
	hora_fim1 timestamp default now(),
	hora_fim2 timestamp default now(),
	total_horas timestamp default now(),
	data_efetivacao date,
	foreign key(estagio_id) references estagio(id)
);

create table organiza_curso (
	oe_siape numeric(9),
	curso_id int,
	campus_cnpj numeric(14),
	primary key(oe_siape, curso_id, campus_cnpj),
	foreign key(oe_siape) references funcionario(siape),
	foreign key(curso_id) references curso(id),
foreign key(campus_cnpj) references campus(cnpj)
);

create table apolice(
	numero varchar(50) primary key,
	estagio_id int,
	seguradora varchar(50),
	foreign key(estagio_id) references estagio(id)
);

create table relatorio(
	id int auto_increment primary key,
	endereco varchar(30),
	data_envio date,
	estagio_id int,
	foreign key(estagio_id) references estagio(id)
);

create table comentario_relatorio(
	id int auto_increment primary key,
	data date,
	descricao varchar(1000),
	relatorio_id int,
	po_siape numeric(9),
	foreign key(po_siape) references funcionario(siape),
	foreign key(relatorio_id) references relatorio(id)
);

create table orienta_estagio (
    estagio_id int,
    po_siape numeric(9),
    foreign key(po_siape) references funcionario(siape),
    foreign key(estagio_id) references estagio(id)
);

create table oferece_curso (
	id int auto_increment primary key,
	turno varchar(10),
curso_id int,
campus_cnpj numeric(14),
foreign key(campus_cnpj) references campus(cnpj),
foreign key(curso_id) references curso(id)
);

create table leciona (
	po_siape numeric(9),
	oferece_curso_id int,
	primary key(po_siape, oferece_curso_id),
	foreign key(po_siape) references funcionario(siape),
	foreign key(oferece_curso_id) references oferece_curso(id)
);

create table organiza (
	email_oe varchar(50),
	oferece_curso_id int,
	primary key(email_oe, oferece_curso_id),
	foreign key(oferece_curso_id) references oferece_curso(id)
);

create table supervisiona (
	estagio_id int primary key,
	supervisor_id int,
	foreign key(estagio_id) references estagio(id),
	foreign key(supervisor_id) references supervisor(id)
);

create table verificar(
	id int(11)  primary key  NOT NULL auto_increment,
	email varchar(50)  not null,
	codigo varchar(50) unique not null,
	verificado int not null,
	data_geracao datetime,
	tipo int	--Tipo: 0 para confirmação de email, 1 para recuperação
);

insert into status (descricao) values ("Aguardando parecer da secretaria");
insert into status (descricao) values ("Estágio deferido pela secretaria");
insert into status (descricao) values ("Aguardando definição do Professor orientador");
insert into status (descricao) values ("Professor orientador definido. Aguardando que o estudante encaminhe à Coordenadoria de Extensão os documentos (TC, PE, *Minuta de convênio) devidamente assinados");
insert into status (descricao) values ("Aguardando que o estudante retire os documentos na Coordenadoria de Extensão e os encaminhe a secretaria");
insert into status (descricao) values ("Início de Estágio Autorizado. Aguardando que o estudante submeta o relatório de estágio");
insert into status (descricao) values ("Aguardando correção do relatório de estágio");
insert into status (descricao) values ("Relatório de estágio aprovado. Aguardando que o estudante encaminhe o relatório de estágio para a Coordenadoria de Extensão");
insert into status (descricao) values ("Relatório Final de Estágio e Declaração de Conclusão do Estágio enviados à Secretaria");
insert into status (descricao) values ("Estágio concluído");
insert into status (descricao) values ("Convênio de empresa aprovado");
insert into status (descricao) values ("Convênio de empresa reprovado");

-- Adicionando dados pra testar

-- USUARIO (para alunos) a senha é "senha"
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('aluno0@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('aluno1@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('aluno2@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('aluno3@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);

-- USUARIO (para funcionários) a senha é "senha"
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario0@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario1@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario2@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario3@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);


-- ENDEREÇO
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (1, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (2, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (3, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (4, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');

-- ALUNO
INSERT INTO aluno(`cpf`, `nome`, `data_nasc`, `rg_num`, `rg_orgao`, `estado_civil`, `sexo`, `telefone`, `celular`, `nome_pai`, `nome_mae`, `cidade_natal`, `estado_natal`, `acesso`, `usuario_email`, `endereco_id`) VALUES (00000000001,'Nome de um aluno 1','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 1,'aluno0@aluno.com', 1);
INSERT INTO aluno(`cpf`, `nome`, `data_nasc`, `rg_num`, `rg_orgao`, `estado_civil`, `sexo`, `telefone`, `celular`, `nome_pai`, `nome_mae`, `cidade_natal`, `estado_natal`, `acesso`, `usuario_email`, `endereco_id`) VALUES (00000000002,'Nome de um aluno 2','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 1,'aluno1@aluno.com', 2);
INSERT INTO aluno(`cpf`, `nome`, `data_nasc`, `rg_num`, `rg_orgao`, `estado_civil`, `sexo`, `telefone`, `celular`, `nome_pai`, `nome_mae`, `cidade_natal`, `estado_natal`, `acesso`, `usuario_email`, `endereco_id`) VALUES (00000000003,'Nome de um aluno 3','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 1,'aluno2@aluno.com', 3);
INSERT INTO aluno(`cpf`, `nome`, `data_nasc`, `rg_num`, `rg_orgao`, `estado_civil`, `sexo`, `telefone`, `celular`, `nome_pai`, `nome_mae`, `cidade_natal`, `estado_natal`, `acesso`, `usuario_email`, `endereco_id`) VALUES (00000000004,'Nome de um aluno 4','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 0,'aluno3@aluno.com', 4);

-- USUARIOS(para funcionarios) a senha é "senha"
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario1@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario2@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario3@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario4@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario5@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario(`email`, `senha`, `tipo`) VALUES ('funcionario6@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);

-- ENDEREÇO
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (5, 'Logradouro', 'Bairro1', '200', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (6, 'Logradouro', 'Bairro2', '300', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (7, 'Logradouro', 'Bairro3', '400', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (8, 'Logradouro', 'Bairro4', '500', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (9, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (10, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES(11, 'Rua', 'Village do Lago I', 300, '-', 'Montes Claros', 'MG', '39404058');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (12, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco(`id`, `logradouro`, `bairro`, `numero`, `complemento`, `cidade`, `uf`, `cep`) VALUES (13, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');

-- CAMPUS
INSERT INTO campus(`cnpj`, `telefone`, `endereco_id`) VALUES (10727655000462, 3821034141, 11);

-- CURSO
INSERT INTO curso(`id`, `nome`) VALUES (1, 'Ciência da Computação');
INSERT INTO curso(`id`, `nome`) VALUES (2, 'Ciência da Computação');
INSERT INTO curso(`id`, `nome`) VALUES (3, 'Engenharia Química');
INSERT INTO curso(`id`, `nome`) VALUES (4, 'Técnico em Informática');
INSERT INTO curso(`id`, `nome`) VALUES (5, 'Técnico em Química');
INSERT INTO curso(`id`, `nome`) VALUES (6, 'Técnico em Eletrotécnica');
INSERT INTO curso(`id`, `nome`) VALUES (7, 'Técnico em Segurança do Trabalho');

-- OFERECE_CURSO

INSERT INTO oferece_curso(`turno`, `campus_cnpj`, `curso_id`) VALUES ('Integral', 10727655000462, 1);
INSERT INTO oferece_curso(`turno`, `campus_cnpj`, `curso_id`) VALUES ('Integral', 10727655000462, 2);
INSERT INTO oferece_curso(`turno`, `campus_cnpj`, `curso_id`) VALUES ('Diurno', 10727655000462, 3);
INSERT INTO oferece_curso(`turno`, `campus_cnpj`, `curso_id`) VALUES ('Diurno', 10727655000462, 4);
INSERT INTO oferece_curso(`turno`, `campus_cnpj`, `curso_id`) VALUES ('Noturno', 10727655000462, 5);
INSERT INTO oferece_curso(`turno`, `campus_cnpj`, `curso_id`) VALUES ('Noturno', 10727655000462, 6);
INSERT INTO oferece_curso(`turno`, `campus_cnpj`, `curso_id`) VALUES ('Noturno', 10727655000462, 7);

-- FUNCIONARIO
INSERT INTO funcionario(`siape`, `nome`, `bool_po`, `bool_oe`, `bool_ce`, `bool_sra`, `bool_root`, `formacao`, `privilegio`, `usuario_email`, `campus_cnpj`) VALUES (000000001, 'Professor1', 1, 0, 0, 0, 0, 'ticher', 1, 'funcionario1@funcionario.com', 10727655000462);
INSERT INTO funcionario(`siape`, `nome`, `bool_po`, `bool_oe`, `bool_ce`, `bool_sra`, `bool_root`, `formacao`, `privilegio`, `usuario_email`, `campus_cnpj`) VALUES (000000002, 'Professor2', 0, 1, 0, 0, 0, 'ticher', 1, 'funcionario1@funcionario.com', 10727655000462);
INSERT INTO funcionario(`siape`, `nome`, `bool_po`, `bool_oe`, `bool_ce`, `bool_sra`, `bool_root`, `formacao`, `privilegio`, `usuario_email`, `campus_cnpj`) VALUES (000000003, 'Professor3', 0, 0, 1, 0, 0, 'ticher', 1, 'funcionario1@funcionario.com', 10727655000462);
INSERT INTO funcionario(`siape`, `nome`, `bool_po`, `bool_oe`, `bool_ce`, `bool_sra`, `bool_root`, `formacao`, `privilegio`, `usuario_email`, `campus_cnpj`) VALUES (000000004, 'Professor4', 0, 0, 0, 1, 0, 'ticher', 1, 'funcionario1@funcionario.com', 10727655000462);
INSERT INTO funcionario(`siape`, `nome`, `bool_po`, `bool_oe`, `bool_ce`, `bool_sra`, `bool_root`, `formacao`, `privilegio`, `usuario_email`, `campus_cnpj`) VALUES (000000005, 'Professor5', 0, 0, 0, 0, 1, 'ticher', 1, 'funcionario1@funcionario.com', 10727655000462);
INSERT INTO funcionario(`siape`, `nome`, `bool_po`, `bool_oe`, `bool_ce`, `bool_sra`, `bool_root`, `formacao`, `privilegio`, `usuario_email`, `campus_cnpj`) VALUES (000000006, 'Professor6', 1, 1, 1, 1, 1, 'ticher', 1, 'funcionario1@funcionario.com', 10727655000462);

-- ALUNO CURSO
INSERT INTO aluno_estuda_curso(`matricula`, `semestre_inicio`, `ano_inicio`, `curso_id`, `aluno_cpf`) VALUES (1, 1, 1990, 1, 000000001);
INSERT INTO aluno_estuda_curso(`matricula`, `semestre_inicio`, `ano_inicio`, `curso_id`, `aluno_cpf`) VALUES (2, 1, 1990, 2, 000000001);
INSERT INTO aluno_estuda_curso(`matricula`, `semestre_inicio`, `ano_inicio`, `curso_id`, `aluno_cpf`) VALUES (3, 1, 1990, 5, 000000001);
INSERT INTO aluno_estuda_curso(`matricula`, `semestre_inicio`, `ano_inicio`, `curso_id`, `aluno_cpf`) VALUES (4, 1, 1990, 1, 000000001);

-- EMPRESA
INSERT INTO empresa(`cnpj`, `nome`, `telefone`, `fax`, `nregistro`, `conselhofiscal`, `endereco_id`, `conveniada`) VALUES (00001, 'Google', 12345566, 12312431, 31231, 'Conselho', 12, 0);
INSERT INTO empresa(`cnpj`, `nome`, `telefone`, `fax`, `nregistro`, `conselhofiscal`, `endereco_id`, `conveniada`) VALUES (00002, 'Microsoft', 12345566, 12312431, 31231, 'Conselho', 13, 1);