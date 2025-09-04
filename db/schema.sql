CREATE DATABASE crud_biblioteca;

USE crud_biblioteca;

CREATE TABLE autores(
    id_autor INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    nacionalidade VARCHAR(45) NOT NULL,
    ano_nascimento INT NOT NULL
);

CREATE TABLE livros(
    id_livro INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL,
    genero VARCHAR(100) NOT NULL,
    ano_publicacao INT NOT NULL,
    situacao_emprestimo BOOLEAN NOT NULL DEFAULT(FALSE),
    fk_autor INT NOT NULL,
    FOREIGN KEY (fk_autor) REFERENCES autores(id_autor)
);

CREATE TABLE leitores(
    id_leitor INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    email VARCHAR(200) NOT NULL,
    telefone INT NOT NULL
);

CREATE TABLE emprestimos(
    id_emprestimo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    data_emprestimo DATE NOT NULL DEFAULT(CURRENT_DATE),
    data_devolucao DATE NOT NULL,
    situacao BOOLEAN NOT NULL DEFAULT(FALSE),
    fk_livro INT NOT NULL,
    fk_leitor INT NOT NULL,
    FOREIGN KEY (fk_livro) REFERENCES livros(id_livro),
    FOREIGN KEY (fk_leitor) REFERENCES leitores(id_leitor)
);