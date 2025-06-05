create TABLE
    tb_estudantes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        data_nascimento DATE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        ativo boolean NOT NULL default 1,
        criado_em DATETIME DEFAULT current_timestamp,
        desativado_em DATE NULL
    );

CREATE TABLE
    tb_turmas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        tipo VARCHAR(50),
        ativa boolean NOT NULL default 1,
        criado_em DATETIME DEFAULT current_timestamp,
        desativado_em DATE NULL
    );

CREATE TABLE
    tb_matriculas (
        estudante_id INT,
        turma_id INT,
        data_matricula DATETIME DEFAULT current_timestamp,
        PRIMARY KEY (estudante_id, turma_id),
        FOREIGN KEY (estudante_id) REFERENCES tb_estudantes (id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES tb_turmas (id) ON DELETE CASCADE
    );

CREATE TABLE
    tb_usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        estudante_id INT NOT NULL,
        email UNIQUE NOT NULL,
        senha NOT NULL FOREIGN KEY (estudante_id) REFERENCES tb_estudantes (id) ON DELETE CASCADE
    );