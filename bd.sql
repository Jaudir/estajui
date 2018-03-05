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
	cargo varchar(50),
	habilitacao varchar(100),
	empresa_cnpj numeric(14),
	foreign key(empresa_cnpj) references empresa(cnpj)
);

create table campus(
	cnpj numeric(14) primary key,
	telefone numeric(11),
	endereco_id int,
	foreign key(endereco_id) references endereco(id) on delete cascade
);

create table curso(
	id int auto_increment primary key,
	nome varchar(40)
);

create table status(
	codigo int auto_increment primary key,
	descricao varchar(170),
	texto TEXT,
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

create table oferece_curso (
    id int auto_increment primary key,
    turno varchar(10),
    curso_id int,
    campus_cnpj numeric(14),
    oe_siape numeric(9),
    foreign key(campus_cnpj) references campus(cnpj),
    foreign key(curso_id) references curso(id),
    foreign key(oe_siape) references funcionario(siape)
);

create table aluno_estuda_curso(
	matricula int unique primary key,
	semestre_inicio int,
	ano_inicio int,
	oferece_curso_id int,
	aluno_cpf numeric(11),
	foreign key(oferece_curso_id) references oferece_curso(id),
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
	endereco_tc varchar(100),
	endereco_pe varchar(100),
	horas_contabilizadas TIME,
	aluno_cpf numeric(11),
	empresa_cnpj numeric(14),
	aluno_estuda_curso_matricula int,
	po_siape numeric(9),
	status_codigo int,
	foreign key(po_siape) references funcionario(siape),
	foreign key(aluno_cpf ) references aluno(cpf),
	foreign key(empresa_cnpj) references empresa(cnpj),	
	foreign key(aluno_estuda_curso_matricula) references aluno_estuda_curso(matricula)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
	foreign key(status_codigo) references status(codigo)
);

create table modifica_status(
    id int auto_increment primary key,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,	
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
        data DATETIME DEFAULT CURRENT_TIMESTAMP,	
	descricao TEXT,
	endereco_correcao varchar(30),
	estagio_id int,
	po_siape numeric(9),
	foreign key(po_siape) references funcionario(siape),
	foreign key(estagio_id) references estagio(id)
);

create table plano_estagio(
	setor_unidade varchar(100),
	estagio_id int primary key, 
	data_assinatura date,
	atividades TEXT,
	remuneracao real,
	vale_transporte real,
	data_ini date,
	data_fim date,
	hora_inicio1 TIME,
	hora_inicio2 TIME,
	hora_fim1 TIME,
	hora_fim2 TIME,
	total_horas TIME,
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
	nome varchar(50),
	tipo varchar(10),
	conteudo LONGBLOB,
	data_envio date,
	estagio_id int,
	foreign key(estagio_id) references estagio(id)
);

create table comentario_relatorio(
	id int auto_increment primary key,
        data DATETIME DEFAULT CURRENT_TIMESTAMP,	
	descricao TEXT,
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
	foreign key(oferece_curso_id) references oferece_curso(id),
	foreign key(email_oe) references usuario(email)
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
	data_geracao date, 
	verificado int not null,
	foreign key(email ) references usuario(email)
);

insert into status (descricao) values ("Aguardando parecer da secretaria");
insert into status (descricao) values ("Estágio deferido pela secretaria");
insert into status (descricao) values ("Aguardando definição do Professor orientador");
insert into status (descricao) values ("Professor orientador definido. Aguardando que o estudante encaminhe à Coordenadoria de Extensão os documentos (TC, PE, *Minuta de convênio) devidamente assinados");
insert into status (descricao) values ("Aguardando que o estudante retire os documentos na Coordenadoria de Extensão e os encaminhe a secretaria");
insert into status (descricao, texto) values ("Início de Estágio Autorizado. Aguardando que o estudante submeta o relatório de estágio", "Os documentos iniciais do estágio foram entregues e validados, você pode iniciar o estágio como estimado, após o término do estágio redija o relatório final como descrito no modelo e envie para análise do orientador.");
insert into status (descricao) values ("Aguardando correção do relatório de estágio");
insert into status (descricao) values ("Relatório de estágio aprovado. Aguardando que o estudante encaminhe o relatório de estágio para a Coordenadoria de Extensão");
insert into status (descricao) values ("Relatório Final de Estágio e Declaração de Conclusão do Estágio enviados à Secretaria");
insert into status (descricao) values ("Reentregar documentos do estágio na secretaria");
insert into status (descricao) values ("Convênio de empresa aprovado");
insert into status (descricao) values ("Estágio concluído");
insert into status (descricao) values ("Convênio de empresa reprovado");
insert into status (descricao) values ("Estágio reprovado");

-- Adicionando dados pra testar

-- USUARIO (para alunos) a senha é "senha"
INSERT INTO usuario (email, senha, tipo) VALUES ('aluno0@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);
INSERT INTO usuario (email, senha, tipo) VALUES ('aluno1@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);
INSERT INTO usuario (email, senha, tipo) VALUES ('aluno2@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);
INSERT INTO usuario (email, senha, tipo) VALUES ('aluno3@aluno.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 1);


-- ENDEREÇO
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (1, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (2, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (3, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (4, 'Logradouro', 'Bairro', '000', 'comp', 'Montes Claros', 'MG', '12345678');

-- ALUNO
INSERT INTO aluno (cpf, nome, data_nasc, rg_num, rg_orgao, estado_civil, sexo, telefone, celular, nome_pai, nome_mae, cidade_natal, estado_natal, acesso, usuario_email, endereco_id) VALUES (16380342656,'Nome de um aluno 1','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 1,'aluno0@aluno.com', 1);
INSERT INTO aluno (cpf, nome, data_nasc, rg_num, rg_orgao, estado_civil, sexo, telefone, celular, nome_pai, nome_mae, cidade_natal, estado_natal, acesso, usuario_email, endereco_id) VALUES (94634652943,'Nome de um aluno 2','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 1,'aluno1@aluno.com', 2);
INSERT INTO aluno (cpf, nome, data_nasc, rg_num, rg_orgao, estado_civil, sexo, telefone, celular, nome_pai, nome_mae, cidade_natal, estado_natal, acesso, usuario_email, endereco_id) VALUES (38594126476,'Nome de um aluno 3','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 1,'aluno2@aluno.com', 3);
INSERT INTO aluno (cpf, nome, data_nasc, rg_num, rg_orgao, estado_civil, sexo, telefone, celular, nome_pai, nome_mae, cidade_natal, estado_natal, acesso, usuario_email, endereco_id) VALUES (57927414410,'Nome de um aluno 4','2000-01-30','123456789012345','SSP','solteiro','masculino',00000000011, 00000000011,'Joao Pai','Joao Mae','MOC HELL','MG', 0,'aluno3@aluno.com', 4);

-- USUARIOS(para funcionarios) a senha é "senha"
INSERT INTO usuario (email, senha, tipo) VALUES ('funcionario1@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario (email, senha, tipo) VALUES ('funcionario2@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario (email, senha, tipo) VALUES ('funcionario3@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario (email, senha, tipo) VALUES ('funcionario4@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario (email, senha, tipo) VALUES ('funcionario5@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);
INSERT INTO usuario (email, senha, tipo) VALUES ('funcionario6@funcionario.com', '$2y$10$89a178NmXg.4XRDj5KB1h.ZRYnsN3CockVltOQvrkRRnAsx2KPqjW', 2);

-- ENDEREÇO
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (5, 'Logradouro', 'Bairro1', '200', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (6, 'Logradouro', 'Bairro2', '300', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (7, 'Logradouro', 'Bairro3', '400', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (8, 'Logradouro', 'Bairro4', '500', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (9, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (10, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES(11, 'Rua', 'Village do Lago I', 300, '-', 'Montes Claros', 'MG', '39404058');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (12, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');
INSERT INTO endereco (id, logradouro, bairro, numero, complemento, cidade, uf, cep) VALUES (13, 'Logradouro', 'Bairro5', '600', 'Chaplin', 'MOC HELL', 'MG', '12345678');

-- CAMPUS
INSERT INTO campus (cnpj, telefone, endereco_id) VALUES (10727655000462, 3821034141, 11);

-- CURSO
INSERT INTO curso VALUES (1, 'Ciência da Computação');
INSERT INTO curso VALUES (2, 'Engenharia Química');
INSERT INTO curso VALUES (3, 'Técnico em Informática');
INSERT INTO curso VALUES (4, 'Técnico em Química');
INSERT INTO curso VALUES (5, 'Técnico em Eletrotécnica');
INSERT INTO curso VALUES (6, 'Técnico em Segurança do Trabalho');

-- FUNCIONARIO
INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES (000000001, 'Professor1', 1, 0, 0, 0, 0, 'ticher', 1, 'funcionario1@funcionario.com', 10727655000462);
INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES (000000002, 'Professor2', 0, 1, 0, 0, 0, 'ticher', 1, 'funcionario2@funcionario.com', 10727655000462);
INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES (000000003, 'Professor3', 0, 0, 1, 0, 0, 'ticher', 1, 'funcionario3@funcionario.com', 10727655000462);
INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES (000000004, 'Professor4', 0, 0, 0, 1, 0, 'ticher', 1, 'funcionario4@funcionario.com', 10727655000462);
INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES (000000005, 'Professor5', 0, 0, 0, 0, 1, 'ticher', 1, 'funcionario5@funcionario.com', 10727655000462);
INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES (000000006, 'Professor6', 1, 1, 1, 1, 1, 'ticher', 1, 'funcionario6@funcionario.com', 10727655000462);


-- OFERECE CURSO
INSERT INTO oferece_curso (id, turno, curso_id, campus_cnpj, oe_siape) VALUES (1, 'Integral', 1, 10727655000462, 1 );
INSERT INTO oferece_curso (id, turno, curso_id, campus_cnpj, oe_siape) VALUES (2, 'Integral', 2, 10727655000462, 2 );
INSERT INTO oferece_curso (id, turno, curso_id, campus_cnpj, oe_siape) VALUES (3, 'Noturno', 1, 10727655000462, 3 );
INSERT INTO oferece_curso (id, turno, curso_id, campus_cnpj, oe_siape) VALUES (4, 'Noturno', 2, 10727655000462, 4 );
INSERT INTO oferece_curso(id, turno,campus_cnpj,curso_id, oe_siape) VALUES (5, 'Diurno', 10727655000462, 3, 1);
INSERT INTO oferece_curso(id, turno,campus_cnpj,curso_id, oe_siape) VALUES (6, 'Diurno', 10727655000462, 4, 1);
INSERT INTO oferece_curso(id, turno,campus_cnpj,curso_id, oe_siape) VALUES (7, 'Noturno', 10727655000462, 5, 1);
INSERT INTO oferece_curso(id, turno,campus_cnpj,curso_id, oe_siape) VALUES (8, 'Noturno', 10727655000462, 6, 1);


-- ALUNO CURSO
INSERT INTO aluno_estuda_curso (matricula, semestre_inicio, ano_inicio, oferece_curso_id, aluno_cpf) VALUES (1, 1, 1990, 1, 16380342656);
INSERT INTO aluno_estuda_curso (matricula, semestre_inicio, ano_inicio, oferece_curso_id, aluno_cpf) VALUES (2, 1, 1990, 2, 94634652943);
INSERT INTO aluno_estuda_curso (matricula, semestre_inicio, ano_inicio, oferece_curso_id, aluno_cpf) VALUES (3, 1, 1990, 2, 38594126476);
INSERT INTO aluno_estuda_curso (matricula, semestre_inicio, ano_inicio, oferece_curso_id, aluno_cpf) VALUES (4, 1, 1990, 2, 57927414410);
INSERT INTO aluno_estuda_curso (matricula, semestre_inicio, ano_inicio, oferece_curso_id, aluno_cpf) VALUES (5, 1, 1990, 2, 16380342656);

-- EMPRESA
INSERT INTO empresa (cnpj, nome, telefone, fax, nregistro, conselhofiscal, endereco_id, conveniada) VALUES (00001, 'Google', 12345566, 12312431, 31231, 'Conselho', 12, 0);
INSERT INTO empresa (cnpj, nome, telefone, fax, nregistro, conselhofiscal, endereco_id, conveniada) VALUES (00002, 'Microsoft', 12345566, 12312431, 31231, 'Conselho', 13, 1);

-- Estagios
INSERT INTO estagio(bool_aprovado, bool_obrigatorio, justificativa, aluno_cpf, empresa_cnpj, aluno_estuda_curso_matricula, po_siape, status_codigo)
VALUES (1, 1, 'justificativa05', 16380342656, 1, 1, 1, 1),
(1, 1, 'justificativa06', 94634652943, 2, 2, 2, 2),
(1, 1, 'justificativa07', 38594126476, 1, 1, 3, 3),
(1, 1, 'justificativa08', 57927414410, 2, 4, 4, 4),
(1, 1, 'justificativa09', 16380342656, 1, 1, 5, 5),
(1, 1, 'justificativa10', 94634652943, 2, 4, 6, 6),
(1, 1, 'justificativa11', 38594126476, 1, 1, 1, 7),
(1, 1, 'justificativa12', 57927414410, 2, 2, 2, 8),
(1, 1, 'justificativa13', 16380342656, 1, 2, 3, 9),
(1, 1, 'justificativa14', 94634652943, 2, 4, 4, 10),
(1, 1, 'justificativa15', 38594126476, 1, 1, 5, 11);
INSERT INTO estagio(justificativa, aluno_cpf, empresa_cnpj, aluno_estuda_curso_matricula, po_siape, status_codigo)
VALUES('justificativa01', 16380342656, 2, 1, 5, 12),
('justificativa02', 94634652943, 1, 4, 6, 11),
('justificativa03', 94634652943, 2, 2, 3, 10),
('justificativa04', 94634652943, 1, 1, 2, 9);


-- PLANO DE ESTÁGIO
INSERT INTO plano_estagio(estagio_id, data_ini, data_fim)
VALUES (1, '2017-01-01', '2017-06-01'),
(2,'2017-01-02', '2017-06-02'),
(3,'2017-01-03', '2017-06-03'),
(4,'2017-01-04', '2017-06-04');

INSERT INTO plano_estagio(estagio_id, data_ini, data_fim)
VALUES
(5, '2017-01-05', '2017-01-05'),
(6, '2017-01-06', '2017-01-06'),
(7, '2017-01-07', '2017-01-07'),
(8, '2017-01-08', '2017-01-08'),
(9, '2017-01-09', '2017-01-09'),
(10, '2017-01-10', '2017-01-10'),
(11, '2017-01-11', '2017-01-11'),
(12, '2017-01-12', '2017-01-12'),
(13, '2017-01-13', '2017-01-13'),
(14, '2017-01-14', '2017-01-14'),
(15, '2017-01-15', '2017-01-15');

-- APÓLICE
INSERT INTO apolice(numero, estagio_id, seguradora)
VALUES
(1, 1, 'seguradora01'),
(2, 2, 'seguradora02'),
(3, 3, 'seguradora03'),
(4, 4, 'seguradora04'),
(5, 5, 'seguradora05'),
(6, 6, 'seguradora06'),
(7, 7, 'seguradora07'),
(8, 8, 'seguradora08'),
(9, 9, 'seguradora09'),
(10, 10, 'seguradora10'),
(11, 11, 'seguradora11'),
(12, 12, 'seguradora12'),
(13, 13, 'seguradora13'),
(14, 14, 'seguradora13'),
(15, 15, 'seguradora15');

-- Responsavel
INSERT INTO responsavel(email, nome, telefone,cargo, empresa_cnpj, aprovado)
VALUES
('responsavel1@email.com', 'Responsável1',00000000011 , 'cargo01', 1, 1),
('responsavel2@email.com', 'Responsável2', 00000000011, 'cargo02', 2, 0);

-- SUPERVISOR
INSERT INTO supervisor(nome, cargo, habilitacao, empresa_cnpj)
VALUES
('supervisor01', 'cargo01', 'habilitacao01', 1),
('supervisor02', 'cargo02', 'habilitacao02', 2),
('supervisor03', 'cargo03', 'habilitacao03', 1),
('supervisor04', 'cargo04', 'habilitacao04', 2),
('supervisor05', 'cargo05', 'habilitacao05', 1),
('supervisor06', 'cargo06', 'habilitacao06', 2),
('supervisor07', 'cargo07', 'habilitacao07', 1),
('supervisor08', 'cargo08', 'habilitacao08', 2),
('supervisor09', 'cargo09', 'habilitacao09', 1),
('supervisor10', 'cargo10', 'habilitacao10', 2),
('supervisor11', 'cargo11', 'habilitacao11', 1),
('supervisor12', 'cargo12', 'habilitacao12', 2),
('supervisor13', 'cargo13', 'habilitacao13', 1),
('supervisor14', 'cargo14', 'habilitacao14', 2),
('supervisor15', 'cargo15', 'habilitacao15', 1);

-- SUPERVISIONA
INSERT INTO supervisiona(estagio_id, supervisor_id)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15);
