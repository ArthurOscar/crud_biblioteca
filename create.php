<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["adicionarAutor"])) {
        $nome = $_POST["nome"];
        $nascionalidade = $_POST["nacionalidade"];
        $nascimento = $_POST["nascimento"];

        $sql = "INSERT INTO autores (nome, nacionalidade, ano_nascimento) VALUES ('$nome', '$nascionalidade','$nascimento')";

        if ($conn->query($sql) === TRUE) {
            header("Location: read.php");
            $conn->close();
            exit();
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
    if (isset($_POST["adicionarLivro"])) {
        $titulo = $_POST["titulo"];
        $genero = $_POST["genero"];
        $publicacao = $_POST["publicacao"];
        $fk_autor = $_POST["fk_autor"];

        if ($publicacao <= '2025' && $publicacao >= '1500') {
            $sql = "SELECT id_autor FROM autores WHERE id_autor = $fk_autor";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql = "INSERT INTO livros (titulo, genero, ano_publicacao, fk_autor) VALUES ('$titulo', '$genero','$publicacao', '$fk_autor')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: read.php");
                    $conn->close();
                    exit();
                } else {
                    echo "Erro: " . $sql . "<br>" . $conn->error;
                    $conn->close();
                }
            } else {
                echo "Erro: Autor com ID $fk_autor não existe. <br>" . $conn->error;
            }
        } else {
            echo "Erro: Ano de publicação inválido. Deve estar entre 1500 e 2025.<br>";
        }
    }
    if (isset($_POST["adicionarLeitor"])) {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];

        $sql = "INSERT INTO leitores (nome, email, telefone) VALUES ('$nome', '$email','$telefone')";

        if ($conn->query($sql) === TRUE) {
            header("Location: read.php");
            $conn->close();
            exit();
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
    if (isset($_POST["criarEmprestimo"])) {
        $data_emprestimo = $_POST["data_emprestimo"];
        $data_devolucao = $_POST["data_devolucao"];
        $fk_livro = $_POST["fk_livro"];
        $fk_leitor = $_POST["fk_leitor"];

        if ($data_devolucao > $data_emprestimo) {
            $sql = "SELECT id_livro FROM livros WHERE id_livro = $fk_livro";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql = "SELECT id_leitor FROM leitores WHERE id_leitor = $fk_leitor";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $sql = "INSERT INTO emprestimos (data_emprestimo, data_devolucao, fk_livro, fk_leitor) VALUES ('$data_emprestimo', '$data_devolucao','$fk_livro', '$fk_leitor')";
                    if ($conn->query($sql) === TRUE) {
                        header("Location: read.php");
                        $conn->close();
                        exit();
                    } else {
                        echo "Erro: " . $sql . "<br>" . $conn->error;
                        $conn->close();
                    }
                } else {
                    echo "Erro: Leitor com ID $fk_leitor não existe. <br>" . $conn->error;
                }
            } else {
                echo "Erro: Livro com ID $fk_livro não existe. <br>" . $conn->error;
            }
        } else {
            echo "Erro: Data de devolução deve ser posterior à data de empréstimo.<br>";
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Registros</title>
</head>

<body>
    <div style="display: flex; gap: 10%; padding: 20px; ">
        <form method="POST">
            <h2>Adicionar Autor</h2>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="form-control" required>
            <br>
            <label for="nacionalidade">Nacionalidade:</label>
            <input type="text" name="nacionalidade" class="form-control" required>
            <br>
            <label for="nascimento">Ano de nascimento:</label>
            <input type="number" name="nascimento" class="form-control" required>
            <br>
            <button type="submit" name="adicionarAutor" class="btn btn-primary">Adicionar Autor</button>
        </form>
        <form method="POST">
            <h2>Adicionar Livro</h2>
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" class="form-control" required>
            <br>
            <label for="genero">Genêro:</label>
            <input type="text" name="genero" class="form-control" required>
            <br>
            <label for="publicacao">Ano de Publicação:</label>
            <input type="number" name="publicacao" class="form-control" required>
            <br>
            <label for="fk_autor">Autor (ID):</label>
            <input type="number" name="fk_autor" class="form-control" required>
            <br>
            <button type="submit" name="adicionarLivro" class="btn btn-primary">Adicionar Livro</button>
        </form>
        <form method="POST">
            <h2>Adicionar Leitor</h2>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="form-control" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
            <br>
            <label for="nascimento">Telefone:</label>
            <input type="number" name="telefone" class="form-control" required >
            <br>
            <button type="submit" name="adicionarLeitor" class="btn btn-primary">Adicionar Leitor</button>
        </form>
        <form method="POST">
            <h2>Criar Empréstimo</h2>
            <label for="data_emprestimo">Data do Empréstimo:</label>
            <input type="date" name="data_emprestimo" class="form-control" required>
            <br>
            <label for="data_devolucao">Data da Devoulução:</label>
            <input type="date" name="data_devolucao" class="form-control" required>
            <br>
            <label for="fk_livro">Livro (ID):</label>
            <input type="number" name="fk_livro" class="form-control" required>
            <br>
            <label for="fk_leitor">Leitor (ID):</label>
            <input type="number" name="fk_leitor" class="form-control" required>
            <br>
            <button type="submit" name="criarEmprestimo" class="btn btn-primary">Criar Empréstimo</button>
        </form>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</body>

</html>