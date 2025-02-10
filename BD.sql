create database bdlionsassociados;
use bdlionsassociados;

create table if not exists tbCargos(
	id_cargo int unsigned auto_increment primary key,
    desc_cargo varchar(50) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbFuncionarios(
	id_funcionario int unsigned auto_increment primary key,
    nome varchar(100) not null,
    login varchar(60),
    senha varchar(15),
    path_imgFun varchar(100) NOT NULL,
    cod_cargo int unsigned,
    foreign key (cod_cargo) references tbCargos (id_cargo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbSituacaoLead(
	id_situacao int unsigned auto_increment primary key,
    nome_situacao varchar(50) not null,
    desc_situacao varchar(300)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbOrigemLead(
	id_origem int unsigned auto_increment primary key,
    nome_origem varchar(50) not null,
    desc_origem varchar(300)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbHorarioLead(
	id_horario int unsigned auto_increment primary key,
    desc_horario varchar(50) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbLeads(
	id_Lead int unsigned auto_increment primary key,
    nome varchar(100) not null,
    email varchar(60),
    celular varchar(15) not null unique, 
    data_recebimento datetime DEFAULT CURRENT_TIMESTAMP,
    data_modificacao datetime DEFAULT null,
    cod_funcionario int unsigned,
    cod_origem int unsigned,
    cod_horario int unsigned,
    foreign key (cod_funcionario) references tbFuncionarios (id_funcionario),
    foreign key (cod_origem) references tbOrigemLead (id_origem),
    foreign key (cod_horario) references tbHorarioLead (id_horario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbProblemaLead(
	desc_problema varchar(600),
    cod_situacao int unsigned,
    cod_lead int unsigned,
    foreign key (cod_situacao) references tbSituacaoLead (id_situacao),
    foreign key (cod_Lead) references tbLeads (id_Lead)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbFaseLead(
	id_fase int unsigned auto_increment primary key,
    nome_fase varchar(50) not null,
    desc_fase varchar(500)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table if not exists tbFaseOportunidade(
	id_fase int unsigned auto_increment primary key,
    nome_fase varchar(50) not null,
    desc_fase varchar(500)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into tbFaseOportunidade (nome_fase, desc_fase) values 
("Em aberto", "É preciso entrar em contato novamente"),
("Não podemos ajudar", "Não foi possível encontrar uma solução ideal"),
("Achou muito caro", "Lead achou o serviço muito caro durante a negociação"),
("Parou de responder", "Parou de responder as mensagens e não atende ligação mais"),
("Negociação", "Realizou negociação com o lead, aguardando confirmação"),
("Perdido", "Não contratou nossos serviços"),
("Ganho", "Nosso novo cliente, venda realizada com sucesso");

create table if not exists tbRetornos(
	protocolo int unsigned auto_increment primary key,
    data_protocolo datetime DEFAULT CURRENT_TIMESTAMP,
    observacao varchar(500),
	cod_fase int unsigned,
    cod_Lead int unsigned,
    cod_funcionario int unsigned,
    foreign key (cod_fase) references tbFaseLead (id_fase),
    foreign key (cod_Lead) references tbLeads (id_Lead),
    foreign key (cod_funcionario) references tbFuncionarios (id_funcionario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into tbFaseLead (nome_fase, desc_fase) values
("Sem contato", "Não conseguiu entrar em contato"),
("Não queria nada", "Conseguiu entrar em contato, mas não precisava de nossos serviços"),
("Não podemos ajudar", "Não foi possível encontrar uma solução ideal"),
("Problema já solucionado", "Já resolveu o problema com outras empresas ou de alguma outra forma"),
("Cliente da Lions Associados", "Já é cliente fechado com a Lions Associados, não é uma lead"),
("Enviado mensagem", "Liguei e não atendeu, mandei mensagem e estou no aguardo");

insert into tbHorarioLead (desc_horario) values 
("Manhã (09h - 12h)"),
("Tarde (12h - 18h)"),
("Noite (18h - 22h)"),
("Não informado");

insert into tbOrigemLead (nome_origem) values
("Diário Oficial"),
("Indicação"),
("Formulário do Site"),
("Whatsapp (Site)"),
("Xlab (Meta Ads)"),
("Facebook"),
("Instagram"),
("Meta Ads"),
("Ativo"),
("Disparo (E-mail)"),
("Disparo (SMS)"),
("Outro"),
("Xlab (Google Ads)"),
("Disparo (Whatsapp"),
("Xlab (Facebook)"),
("Xlab (Instagram)"),
("Lista Detran"),
("Google Ads");

insert into tbCargos (desc_cargo) values 
("Desenvolvedor(a)"),
("Administrador(a)"),
("Supervisor(a)"),
("Consultor(a)"),
("Sucesso do Cliente");

insert into tbSituacaoLead (nome_situacao, desc_situacao) values 
("CNH Suspensa", ""),
("CNH Cassada", ""),
("Renovação", ""),
("Reciclagem", ""),
("Bafômetro", ""),
("Pontuação", ""),
("Multas", ""),
("Limpa Nome", ""),
("Imobiliario", ""),
("Outros", ""),
("Não informado", ""),
("Primeira Habilitação", ""),
("Consulta na CNH", ""),
("Permissão/Provisória", "");

insert into tbFuncionarios (nome, login, senha, path_imgFun, cod_cargo) values 
('David Henrique', 'david.silva', '29853@div', '../img/funcionarios/david.png', 1),
('José Hilton', 'zehilton', '54321@not', '../img/funcionarios/hilton.jpg', 2),
('Joyce Aparecida', 'joyce.aparecida', '13579@ecy', '../img/funcionarios/joyce.jpg', 4),
('Maisa Moreira', 'maisa', '15973@asi', '../img/funcionarios/maisa.jpg', 3),
('Fabiana Silva', 'fabiana.silva', '86420@ana', '../img/funcionarios/fabiana.jpg', 3),
('Sara Aparecida', 'sara.aparecida', '47586@ara', '../img/funcionarios/sara.jpg', 5),
('Michele Luzzi', 'michile.luzzi', '89465@ele', '../img/funcionarios/michele.png', 4),
('Jeniffer Russi', 'jeniffer.russi', '94752@ref', '../img/funcionarios/jeniffer.png', 4),
('Juan Carlos', 'juan.carlos', '19738@nau', '../img/funcionarios/juan.png', 4),
('Maria Eduarda', 'maria.eduarda', '51847@air', '../img/funcionarios/maria.png', 4);
/* ('Daniele Gomes', 'daniele.gomes', '18742@ele', '../img/funcionarios/dani.jpg', 6)*/ 
select * from tbFuncionarios;
/*

("Paulo Vitor", "paulo.vitor", "48625@olu", "../img/funcionarios/paulo.png", 4); 
Funcionários Desligados*/

update tbOrigemLead set nome_origem = "Xlab (Meta Ads)" where id_origem = 5;

create table if not exists tbNotificacao(
	id int primary key auto_increment,
    mensagem varchar(200) not null,
    cod_funcionario int unsigned,
    status int,
	foreign key (cod_funcionario) references tbFuncionarios (id_funcionario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into tbNotificacao (mensagem, cod_funcionario, status) values ("Nova Lead", 1, 0);
select * from tbNotificacao;

-- Tabela de Vendas
create table if not exists tbVendas(
    id int unsigned auto_increment primary key,
    cod_lead int unsigned,
    cod_funcionario int unsigned,
    valor decimal(10, 2) not null,
    data_venda datetime DEFAULT CURRENT_TIMESTAMP,
    cod_servico int(3),
    descricao varchar(500),
    foreign key (cod_servico) references tbServico (id),
    foreign key (cod_lead) references tbLeads (id_Lead),
    foreign key (cod_funcionario) references tbFuncionarios (id_funcionario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Agendamentos
create table if not exists tbAgendamentos(
    id int unsigned auto_increment primary key,
    cod_lead int unsigned,
    cod_oportunidade int unsigned,
    cod_funcionario int unsigned,
    descricao varchar(150),
    data_agendamento datetime DEFAULT CURRENT_TIMESTAMP,
    status int,
    foreign key (cod_lead) references tbLeads (id_Lead),
    foreign key (cod_oportunidade) references tbOportunidades (id),
    foreign key (cod_funcionario) references tbFuncionarios (id_funcionario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into tbAgendamentos (cod_lead, cod_funcionario, descricao, data_inicio, data_fim, status) values (5, 3, "Novo Evento", "20-jun-2024 14:35:42", "20-jun-2024 14:35:42", 0);

create table if not exists tbServicos(
	id int unsigned auto_increment primary key,
    nome varchar(150)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into tbServicos (nome) values ("Adm. de Suspensão"),
("Adm.de Bafômetro"),
("Adm. de Cassação"),
("Liminar de Suspensão"),
("Liminar de Cassação"),
("Liminar Permissão"),
("Recurso de Multa"),
("Diligência"),
("Termo de Reabilitação"),
("Reciclagem"),
("Reabilitação"),
("Primeira CNH"),
("Renovação"),
("Adição de Categoria"),
("Prontuário"),
("Bloqueio de Placa"),
("Transferência");

create table if not exists tbFormaPagamento(
	id int unsigned auto_increment primary key,
    nome varchar(150)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into tbFormaPagamento (nome) values ("Digitada"),
("Rede"),
("BK"),
("Boleto"),
("Transferência"),
("Pix"),
("Dinheiro"),
("Depósito");

create table if not exists tbOportunidades (
	id int unsigned primary key auto_increment,
    nome varchar(100) not null,
    email varchar(60),
    valor float(10, 2),
    celular varchar(15) not null unique, 
    servico varchar(100),
    data_recebimento datetime DEFAULT CURRENT_TIMESTAMP,
    data_modificacao datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    cod_lead int unsigned,
    cod_funcionario int unsigned,
    cod_origem int unsigned,
    cod_fase int unsigned,
    foreign key (cod_fase) references tbFaseOportunidade (id_fase),
    foreign key (cod_lead) references tbLeads (id_Lead),
    foreign key (cod_funcionario) references tbFuncionarios (id_funcionario),
    foreign key (cod_origem) references tbOrigemLead (id_origem)
);

select * from tbNotas;
select * from tboportunidades;

create table tbNotas(
	protocolo int unsigned auto_increment primary key,
    data_protocolo datetime DEFAULT CURRENT_TIMESTAMP,
    descricao varchar(500),
    cod_Oportunidade int unsigned,
    cod_funcionario int unsigned,
    foreign key (cod_Oportunidade) references tbOportunidades (id),
    foreign key (cod_funcionario) references tbFuncionarios (id_funcionario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into tbOrigemLead (nome_origem) values ("CreativeLeads");

alter table tbLeads add opportunity boolean DEFAULT false;

create table tbDepartamento(
	id int unsigned auto_increment primary key,
    nome varchar(150)
);
select * from tbFuncionarios;

insert into tbFuncionarios (nome, login, senha, path_imgFun, cod_cargo, cod_departamento) values 
('Aline Ferreira', 'aline.ferreira', '19191@eni', '../img/funcionarios/aline.jpg', 6, 2);

ALTER TABLE tbVendas
ADD COLUMN cod_pagamento INT UNSIGNED,
ADD CONSTRAINT fk_cod_pagamento
FOREIGN KEY (cod_pagamento) REFERENCES tbFormaPagamento(id);

CREATE TABLE tbPalavrasChave (
    id_palavra INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único para cada palavra-chave
    palavra VARCHAR(100) NOT NULL,            -- Palavra-chave que será cadastrada pelo dono da empresa
    data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP -- Data de cadastro da palavra-chave, padrão: data atual
);

CREATE TABLE tbPonto (
    id_ponto INT AUTO_INCREMENT PRIMARY KEY,
    cod_funcionario INT UNSIGNED NOT NULL,
    cod_palavra INT NOT NULL,
    horario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cod_funcionario) REFERENCES tbFuncionarios(id_funcionario),
    FOREIGN KEY (cod_palavra) REFERENCES tbPalavrasChave(id_palavra)
);


select * from tbPalavrasChave;
select * from tbPonto;