<?php
include "db.php";
$id = $_GET["id"];
$table = $_GET["table"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["editarAutor"])) {
        $nome = $_POST["nome"];
        $nacionalidade = $_POST["nacionalidade"];
        $nascimento = $_POST["nascimento"];

        $sql = "UPDATE autores SET nome='$nome', nacionalidade='$nacionalidade', ano_nascimento=$nascimento WHERE id_autor = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: read.php");
            $conn->close();
            exit();
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
    if (isset($_POST["editarLivro"])) {
        $titulo = $_POST["titulo"];
        $genero = $_POST["genero"];
        $publicacao = $_POST["publicacao"];
        $fk_autor = $_POST["fk_autor"];

        if ($publicacao <= '2025' && $publicacao >= '1500') {
            $sql = "SELECT id_autor FROM autores WHERE id_autor = $fk_autor";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql = "UPDATE livros SET titulo='$titulo', genero='$genero', ano_publicacao=$publicacao, fk_autor=$fk_autor WHERE id_livro = $id";
                if ($conn->query($sql) === TRUE) {
                    header("Location: read.php");
                    $conn->close();
                    exit();
                } else {
                    echo "Erro: " . $sql . "<br>" . $conn->error;
                    $conn->close();
                }
            } else {
                echo "<script> alert('Erro: Autor com ID $fk_autor não existe.')</script>" . $conn->error;
            }
        } else {
            echo "<script> alert('Erro: Ano de publicação inválido. Deve estar entre 1500 e 2025.')</script>";
        }
    }
    if (isset($_POST["editarLeitor"])) {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];

        $sql = "UPDATE leitores SET nome='$nome', email='$email', telefone='$telefone' WHERE id_leitor = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: read.php");
            $conn->close();
            exit();
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
    if (isset($_POST["editarEmprestimo"])) {
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
                    $sql = "UPDATE emprestimos SET data_emprestimo='$data_emprestimo', data_devolucao='$data_devolucao', fk_livro='$fk_livro', fk_leitor='$fk_leitor' WHERE id_emprestimo = $id";
                    if ($conn->query($sql) === TRUE) {
                        header("Location: read.php");
                        $conn->close();
                        exit();
                    } else {
                        echo "Erro: " . $sql . "<br>" . $conn->error;
                        $conn->close();
                    }
                } else {
                    echo "<script> alert('Erro: Leitor com ID $fk_leitor não existe.')</script>" . $conn->error;
                }
            } else {
                echo "<script> alert('Erro: Livro com ID $fk_livro não existe.')</script>" . $conn->error;
            }
        } else {
            echo "<script> alert('Erro: Data de devolução deve ser posterior à data de empréstimo.')</script>";
        }
    }
}
echo "<div class='texto'";
if ($table === "autores") {
    $sql = "SELECT * FROM autores WHERE id_autor = $id";
} elseif ($table === "livros") {
    $sql = "SELECT * FROM livros WHERE id_livro = $id";
} elseif ($table === "leitores") {
    $sql = "SELECT * FROM leitores WHERE id_leitor = $id";
} elseif ($table === "emprestimos") {
    $sql = "SELECT * FROM emprestimos WHERE id_emprestimo = $id";
};

$result = $conn->query($sql);

if (!$result) {
    die("Erro na query: " . $conn->error);
};

if ($result->num_rows > 0) {
    echo "<div style='padding:20px;'>";
    echo "<table class=' table table-bordered' border='1'><tr>";
    foreach ($result->fetch_fields() as $field) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr>";

    $result->data_seek(0); // volta pro início do resultado
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
};
echo "</div>";
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registros</title>
</head>

<body>
    <div class="texto">
        <?php if ($_GET['table'] === "autores") {
            echo "<form method='POST' class='formCreate'>
            <div class='conteudoForms'>
            <h2 style='color:white;'>Editar Autor</h2>
            <label for='nome'>Nome:</label>
            <input type='text' name='nome' class='form-control' required>
            <br>
            <label for='nacionalidade'>Nacionalidade:</label>
            <input type='text' name='nacionalidade' class='form-control' required>
            <br>
            <label for='nascimento'>Ano de nascimento:</label>
            <input type='number' name='nascimento' class='form-control' required>
            <br>
            <button type='submit' name='editarAutor' class='btn btn-primary'>Editar Autor</button>
            </div>
            </form>";
        };
        if ($_GET['table'] === "livros") {
            echo "<form method='POST' class='formCreate'>
            <div class='conteudoForms'>
            <h2 style='color:white;'>Editar Livro</h2>
            <label for='titulo'>Titulo:</label>
            <input type='text' name='titulo' class='form-control' required>
            <br>
            <label for='genero'>Genêro:</label>
            <input type='text' name='genero' class='form-control' required>
            <br>
            <label for='publicacao'>Ano de Publicação:</label>
            <input type='number' name='publicacao' class='form-control' required>
            <br>
            <label for='fk_autor'>Autor (ID):</label>
            <input type='number' name='fk_autor' class='form-control' required>
            <br>
            <button type='submit' name='editarLivro' class='btn btn-primary'>Editar Livro</button>
            </div>
            </form>";
        };
        if ($_GET['table'] === "leitores") {
            echo "<form method='POST' class='formCreate'>
            <div class='conteudoForms'>
            <h2 style='color:white;'>Editar Leitor</h2>
            <label for='nome'>Nome:</label>
            <input type='text' name='nome' class='form-control' required>
            <br>
            <label for='email'>Email:</label>
            <input type='email' name='email' class='form-control' required>
            <br>
            <label for='nascimento'>Telefone:</label>
            <input type='number' name='telefone' class='form-control' required >
            <br>
            <button type='submit' name='editarLeitor' class='btn btn-primary'>Editar Leitor</button>
            </div>
            </form>";
        };
        if ($_GET['table'] === "emprestimos") {
            echo "<form method='POST' class='formCreate'>
            <div class='conteudoForms'>
            <h2 style='color:white;'>Editar Empréstimo</h2>
            <label for='data_emprestimo'>Data do Empréstimo:</label>
            <input type='date' name='data_emprestimo' class='form-control' required>
            <br>
            <label for='data_devolucao'>Data da Devoulução:</label>
            <input type='date' name='data_devolucao' class='form-control' required>
            <br>
            <label for='fk_livro'>Livro (ID):</label>
            <input type='number' name='fk_livro' class='form-control' required>
            <br>
            <label for='fk_leitor'>Leitor (ID):</label>
            <input type='number' name='fk_leitor' class='form-control' required>
            <br>
            <button type='submit' name='editarEmprestimo' class='btn btn-primary'>Editar Empréstimo</button>
            </div>
            </form>";
        };
        ?>
    </div>
    <div class="texto"">
        <a href="manage.php" style="text-decoration: none; color: white;"><button class="btn btn-primary">Voltar</button></a>
    </div>
    <style>
        .texto {
            display: flex;
            background-image: url('https://i.redd.it/7yx3n3w97b5a1.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.9;
            justify-content: space-between;
            padding: 20px;
        }

        .formCreate {
            width: 30%;
            border: 1px solid white;
            border-radius: 10px;
        }

        .conteudoForms {
            padding: 20px;
        }

        label {
            color: white;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</body>

</html>