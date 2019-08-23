CREATE 	DATABASE dbGetLesson;
USE dbGetLesson;
CREATE TABLE tbComponente(
	idComponente INT PRIMARY KEY AUTO_INCREMENT
    ,	nomeComponente VARCHAR(80) NOT NULL
    ,	siglaComponente VARCHAR(10) NOT NULL
);

CREATE TABLE tbUsuario(
	idUsuario INT PRIMARY KEY AUTO_INCREMENT
    ,	nomeUsuario VARCHAR(100) NOT NULL
	,	rmUsuario VARCHAR(8) NOT NULL
	,	senhaUsuario VARCHAR(255) NOT NULL
    ,	emailUsuario VARCHAR(255) NOT NULL
    ,	nivel INT NOT NULL
);

CREATE TABLE tbCurso(
	idCurso INT PRIMARY KEY AUTO_INCREMENT
    ,	nomeCurso VARCHAR(80)
);

CREATE TABLE tbPeriodo(
	idPeriodo INT PRIMARY KEY AUTO_INCREMENT
    ,	nomePeriodo VARCHAR(80) NOT NULL
);

CREATE TABLE tbTipoPergunta(
	idTipoPergunta INT PRIMARY KEY AUTO_INCREMENT
    ,	nomeTipoPergunta VARCHAR(20) NOT NULL
);

CREATE TABLE tbTurma(
	idTurma INT PRIMARY KEY AUTO_INCREMENT
    ,	nomeTurma VARCHAR(50) NOT NULL
    ,	semestreTurma VARCHAR(20) NOT NULL
    ,	anoTurma VARCHAR(5) NOT NULL
    ,	ultimoDiaTurma DATE NOT NULL
    ,	statusTurma INT NOT NULL
    ,	idCurso INT NOT NULL
    ,	idPeriodo INT NOT NULL
	,	CONSTRAINT fk_TurmaCurso FOREIGN KEY (idCurso) REFERENCES tbCurso(idCurso)
    ,	CONSTRAINT fk_TurmaPeriodo FOREIGN KEY (idPeriodo) REFERENCES tbPeriodo(idPeriodo)
);

CREATE TABLE tbComponenteProfessor(
	idComponenteProfessor INT PRIMARY KEY AUTO_INCREMENT
    ,	idComponente INT NOT NULL
    ,	idUsuario INT NOT NULL
    ,	idTurma INT NOT NULL
    ,	CONSTRAINT fk_ComponenteProfessorComponente FOREIGN KEY (idComponente) REFERENCES tbComponente(idComponente)
    ,	CONSTRAINT fk_ComponenteProfessorProfessor FOREIGN KEY (idUsuario) REFERENCES tbUsuario(idUsuario)
    , 	CONSTRAINT fk_ComponenteProfessorTurma FOREIGN KEY (idTurma) REFERENCES tbTurma(idTurma)
);

CREATE TABLE tbMatricula(
	idMatricula INT PRIMARY KEY AUTO_INCREMENT
    ,	idUsuario INT NOT NULL
    ,	idTurma INT NOT NULL
    ,	CONSTRAINT fk_MatriculaAluno FOREIGN KEY (idUsuario) REFERENCES tbUsuario(idUsuario)
	,	CONSTRAINT fk_MatriculaTurma FOREIGN KEY (idTurma) REFERENCES tbTurma(idTurma)
);

CREATE TABLE tbAtividade(
	idAtividade INT PRIMARY KEY AUTO_INCREMENT
    ,	idComponenteProfessor INT NOT NULL
    ,	dataHoraDeCriacao DATETIME NOT NULL
    ,	dataDeEntrega DATE NOT NULL
    ,	CONSTRAINT fk_AtividadeComponenteProfessor FOREIGN KEY (idComponenteProfessor) REFERENCES tbComponenteProfessor(idComponenteProfessor)
);

CREATE TABLE tbPergunta(
	idPergunta INT PRIMARY KEY AUTO_INCREMENT
    ,	pergunta VARCHAR(500) NOT NULL
    ,	idTipoPergunta INT NOT NULL
    ,	idAtividade INT NOT NULL
    , 	CONSTRAINT fk_PerguntaTipoPergunta FOREIGN KEY (idTipoPergunta) REFERENCES tbTipoPergunta(idTipoPergunta)
    ,	CONSTRAINT fk_PerguntaAtividade FOREIGN KEY (idAtividade) REFERENCES tbAtividade(idAtividade)
);

CREATE TABLE tbResposta(
	idResposta INT PRIMARY KEY AUTO_INCREMENT
    ,	idPergunta INT NOT NULL
    ,	resposta VARCHAR(200) NOT NULL
    ,	certa INT NOT NULL
    ,	CONSTRAINT fk_RespostaPergunta FOREIGN KEY (idPergunta) REFERENCES tbPergunta(idPergunta)
);

CREATE TABLE tbMencao(
	idMencao INT PRIMARY KEY AUTO_INCREMENT
    ,	nomeMencao VARCHAR(2) NOT NULL
    ,	valorMencao INT NOT NULL
);

CREATE TABLE tbAlunoAtividade(
	idAlunoAtividade INT PRIMARY KEY AUTO_INCREMENT
    ,	dataHora DATETIME NOT NULL
    ,	idAluno INT NOT NULL
    ,	idAtividade INT NOT NULL
    ,	idMencao INT NOT NULL
    ,	CONSTRAINT fk_AlunoAtividadeAluno FOREIGN KEY (idAluno) REFERENCES tbUsuario(idUsuario)
    ,	CONSTRAINT fk_AlunoAtividadeAtividade FOREIGN KEY (idAtividade) REFERENCES tbAtividade(idAtividade)
    ,	CONSTRAINT fk_AlunoAtividadeMencao FOREIGN KEY (idMencao) REFERENCES tbAtividade(idAtividade)
);

CREATE TABLE tbAlunoResposta(
	idAlunoResposta INT PRIMARY KEY AUTO_INCREMENT
    ,	resposta TEXT 
    ,	acerto INT
    ,	idAlunoAtividade INT NOT NULL
    ,	idPergunta INT NOT NULL
    ,	CONSTRAINT fk_AlunoRespostaAtividade FOREIGN KEY (idAlunoAtividade) REFERENCES tbAlunoAtividade(idAlunoAtividade)
);