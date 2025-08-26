<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["adicionarAutor"])) {
        $nome = $_POST["nome"];
        $nascionalidade = $_POST["nacionalidade"];
        $nascimento = $_POST["nascimento"];

        $sql = "INSERT INTO autores (nome, nacionalidade, ano_nascimento) VALUES ('$nome', '$nascionalidade','$nascimento')";

        if ($conn->query($sql) === TRUE) {
            header("Location: create.php");
            exit();
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
    if (isset($_POST["adicionarLeitor"])) {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];

        $sql = "INSERT INTO leitores (nome, email, telefone) VALUES ('$nome', '$email','$telefone')";

        if ($conn->query($sql) === TRUE) {
            header("Location: create.php");
            exit();
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
    if (isset($_POST["adicionarLivro"])) {
        $titulo = $_POST["titulo"];
        $genero = $_POST["genero"];
        $publicacao = $_POST["publicacao"];
        $fk_autor = $_POST["fk_autor"];

        if($publicacao <= '2025' && $publicacao >= '1500'){
            $sql = "SELECT id_autor FROM autores WHERE id_autor = $fk_autor";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql = "INSERT INTO livros (titulo, genero, ano_publicacao, fk_autor) VALUES ('$titulo', '$genero','$publicacao', '$fk_autor')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: create.php");
                    exit();
                } else {
                    echo "Erro: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Erro: Autor com ID $fk_autor não existe. <br>" . $conn->error;
            }
        } else {
            echo "Erro: Ano de publicação inválido. Deve estar entre 1500 e 2025.<br>";
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
    <form method="POST">
        <h2>Adicionar Autor</h2>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
        <br>
        <label for="nacionalidade">Nacionalidade:</label>
        <input type="text" name="nacionalidade" required>
        <br>
        <label for="nascimento">Ano de nascimento:</label>
        <input type="number" name="nascimento" required>
        <br>
        <button type="submit" name="adicionarAutor">Adicionar Autor</button>
    </form>
    <form method="POST">
        <h2>Adicionar Leitor</h2>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="nascimento">Telefone:</label>
        <input type="number" name="telefone" required>
        <br>
        <button type="submit" name="adicionarLeitor">Adicionar Leitor</button>
    </form>
    <form method="POST">
        <h2>Adicionar Livro</h2>
        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" required>
        <br>
        <label for="genero">Genêro:</label>
        <input type="text" name="genero" required>
        <br>
        <label for="publicacao">Ano de Publicação:</label>
        <input type="number" maxlength="4" name="publicacao" required>
        <br>
        <label for="fk_autor">Autor (ID):</label>
        <input type="number" name="fk_autor" required>
        <br>
        <button type="submit" name="adicionarLivro">Adicionar Livro</button>
    </form>
</body>

</html>