USE crud_biblioteca;

INSERT INTO autores (nome, nacionalidade, ano_nascimento) VALUES
('Machado de Assis', 'Brasileiro', 1839),
('José Saramago', 'Português', 1922),
('George Orwell', 'Britânico', 1903),
('Jane Austen', 'Britânica', 1775),
('Clarice Lispector', 'Brasileira', 1920);

INSERT INTO livros (titulo, genero, ano_publicacao, fk_autor, situacao_emprestimo) VALUES
('Dom Casmurro', 'Romance', 1899, 1, 0),
('Memórias Póstumas de Brás Cubas', 'Romance', 1881, 1, 0),
('Quincas Borba', 'Romance', 1891, 1, 0),
('Helena', 'Romance', 1876, 1, 0),
('Ensaio sobre a Cegueira', 'Romance', 1995, 2, 0),
('O Evangelho Segundo Jesus Cristo', 'Romance', 1991, 2, 0),
('A Caverna', 'Romance', 2000, 2, 0),
('Todos os Nomes', 'Romance', 1997, 2, 0),
('1984', 'Distopia', 1949, 3, 1),
('A Revolução dos Bichos', 'Sátira Política', 1945, 3, 0),
('Homage to Catalonia', 'Memórias', 1938, 3, 0),
('Keep the Aspidistra Flying', 'Romance', 1936, 3, 0),
('Orgulho e Preconceito', 'Romance', 1813, 4, 0),
('Razão e Sensibilidade', 'Romance', 1811, 4, 0),
('Emma', 'Romance', 1815, 4, 0),
('Mansfield Park', 'Romance', 1814, 4, 0),
('A Hora da Estrela', 'Romance', 1977, 5, 1),
('Laços de Família', 'Contos', 1960, 5, 0),
('Felicidade Clandestina', 'Contos', 1971, 5, 0),
('Perto do Coração Selvagem', 'Romance', 1943, 5, 0);

INSERT INTO leitores (nome, email, telefone) VALUES
('Ana Souza', 'ana.souza@example.com', '11987654321'),
('Carlos Pereira', 'carlos.pereira@example.com', '21998765432'),
('Mariana Oliveira', 'mariana.oliveira@example.com', '31912345678'),
('João Silva', 'joao.silva@example.com', '41945678901'),
('Fernanda Costa', 'fernanda.costa@example.com', '51965432109');

INSERT INTO emprestimos (data_emprestimo, data_devolucao, fk_livro, fk_leitor, situacao) VALUES
('2025-09-01', '2025-09-15', 9, 1, 0),
('2025-08-20', '2025-09-05', 17, 3, 0),
('2025-07-10', '2025-07-25', 5, 2, 1),
('2025-09-02', '2025-09-12', 2, 4, 0),
('2025-09-03', '2025-09-18', 13, 5, 0);