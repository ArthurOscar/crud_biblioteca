<?php
include 'db.php';
$id = $_GET['id'];
$tabela = $_GET['table'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resposta'])) {
    $resposta = $_POST['resposta'];
    if ($resposta === "sim") {
        if ($tabela === "autores") {
            $consulta = $conn->prepare("SELECT COUNT(*) FROM livros WHERE fk_autor = $id");
            $consulta->execute();
            $consulta->bind_result($quantidade);
            $consulta->fetch();
            $consulta->close();

            if ($quantidade > 0) {
                echo "Não é possível excluir este autor: existem livros vinculados.<br>";
                echo "<a href='manage.php'>Voltar</a>";
                $conn->close();
                exit;
            } else {
                $sql = "DELETE FROM $tabela WHERE id_autor=$id";
                if ($conn->query($sql) === true) {
                    echo "Registro excluído com sucesso.";
                } else {
                    echo "Erro" . $sql . "<br>" . $conn->error;
                }
                $conn->close();
                header("Location: read.php");
            }
        } elseif ($tabela === "livros") {
            $consulta = $conn->prepare("SELECT COUNT(*) FROM emprestimos WHERE fk_livro = $id");
            $consulta->execute();
            $consulta->bind_result($quantidade);
            $consulta->fetch();
            $consulta->close();

            if ($quantidade > 0) {
                echo "Não é possível excluir este livro: existem empréstimos vinculados.<br>";
                echo "<a href='manage.php'>Voltar</a>";
                $conn->close();
                exit;
            } else {
                $sql = "DELETE FROM $tabela WHERE id_livro=$id";
                if ($conn->query($sql) === true) {
                    echo "Registro excluído com sucesso.";
                } else {
                    echo "Erro" . $sql . "<br>" . $conn->error;
                }
                $conn->close();
                header("Location: read.php");
            }
        } elseif ($tabela === "leitores") {
            $consulta = $conn->prepare("SELECT COUNT(*) FROM emprestimos WHERE fk_leitor = $id");
            $consulta->execute();
            $consulta->bind_result($quantidade);
            $consulta->fetch();
            $consulta->close();

            if ($quantidade > 0) {
                echo "Não é possível excluir este leitor: existem empréstimos vinculados.<br>";
                echo "<a href='manage.php'>Voltar</a>";
                $conn->close();
                exit;
            } else {
                $sql = "DELETE FROM $tabela WHERE id_leitor=$id";
                if ($conn->query($sql) === true) {
                    echo "Registro excluído com sucesso.";
                } else {
                    echo "Erro" . $sql . "<br>" . $conn->error;
                }
                $conn->close();
                header("Location: read.php");
            }
        } elseif ($tabela === "emprestimos") {
            $sql = "DELETE FROM $tabela WHERE id_emprestimo=$id";
            if ($conn->query($sql) === true) {
                echo "Registro excluído com sucesso.";
            } else {
                echo "Erro" . $sql . "<br>" . $conn->error;
            }
            $conn->close();
            header("Location: read.php");
        }
    }
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir</title>
</head>

<body>
    <form method="POST">
        <label for="excluir">Tem certeza que deseja excluir?</label><br>
        <button name="resposta" value="sim">sim</button>
        <button name="resposta" value="nao">não</button>
    </form>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</body>

</html>