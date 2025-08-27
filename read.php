<?php

include "db.php";
echo "<div style='display: flex; gap: 20px;'>";

echo "<div>";
echo "<h2>Autores</h2>";
$sql = "SELECT * FROM autores";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table Border='1'>
        <tr>
        <th>ID Autor</th>
        <th>Nome</th>
        <th>Nacionalidade</th>
        <th>Nascimento</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id_autor']}</td>
        <td>{$row['nome']}</td>
        <td>{$row['nacionalidade']}</td>
        <td>{$row['ano_nascimento']}</td>
        </tr>";
    };
    echo "</table>";
} else {
    echo "Não foi possivel encontra nenhum autor.<br>";
}
echo "</div>";

echo "<div>";
echo "<h2>Livros</h2>";
$filtro = "";
if (isset($_POST['filtro']) && $_POST['filtro'] != "") {
    $filtro = $_POST['filtro'];
    $sql = "SELECT * FROM livros WHERE genero LIKE '%$filtro%' OR titulo LIKE '%$filtro%' OR ano_publicacao LIKE '%$filtro%'";
} else {
    $sql = "SELECT * FROM livros";
}
$result = $conn->query($sql);

echo "<form method='POST'>
        <input type='text' name='filtro' placeholder='Filtrar por título, gênero ou ano' value='$filtro'>
        <button type='submit'>Filtrar</button>
 </form>";

if ($result->num_rows > 0) {
    echo "<table Border='1'>
        <tr>
            <th>ID Livro</th>
            <th>Título</th>
            <th>Gênero</th>
            <th>Ano de Publicação</th>
            <th>ID Autor</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id_livro']}</td>
        <td>{$row['titulo']}</td>
        <td>{$row['genero']}</td>
        <td>{$row['ano_publicacao']}</td>
        <td>{$row['fk_autor']}</td></tr>";
    };
    echo "</table>";
} else {
    echo "Não foi possivel encontra nenhum livro.<br>";
}
echo "</div>";

echo "<div>";
echo "<h2>Leitores</h2>";
$sql = "SELECT * FROM leitores";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table Border='1'>
        <tr>
        <th>ID Leitor</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id_leitor']}</td>
        <td>{$row['nome']}</td>
        <td>{$row['email']}</td>
        <td>{$row['telefone']}</td>
        </tr>";
    };
    echo "</table>";
} else {
    echo "Não foi possivel encontra nenhum leitor.<br>";
}
echo "</div>";

echo "<div>";
echo "<h2>Empréstimos</h2>";
$sql = "SELECT * FROM emprestimos";
$result = $conn->query($sql);

$sql_livro = "SELECT titulo FROM livros";
$result_livro = $conn->query($sql_livro);
$row_livro = $result_livro->fetch_assoc();

$sql_leitor = "SELECT nome FROM leitores";
$result_leitor = $conn->query($sql_leitor);
$row_leitor = $result_leitor->fetch_assoc();

if ($result->num_rows > 0) {
    echo "<table Border='1'>
        <tr>
        <th>ID Empréstimo</th>
        <th>Data do Empréstimo</th>
        <th>Data da devolução</th>
        <th>Livro</th>
        <th>Leitor</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id_emprestimo']}</td>
        <td>{$row['data_emprestimo']}</td>
        <td>{$row['data_devolucao']}</td>
        <td>{$row_livro['titulo']}</td>
        <td>{$row_leitor['nome']}</td>
        </tr>";
    };
    echo "</table>";
} else {
    echo "Não foi possivel encontra nenhum empréstimo.<br>";
}
echo "</div>";
echo "</div>";

include 'create.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read</title>
</head>