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

$livrosPorPagina = 5;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$offset = ($pagina - 1) * $livrosPorPagina;

$filtro = "";
if (isset($_POST['filtro']) && $_POST['filtro'] != "") {
    $filtro = $_POST['filtro'];
    $sql = "SELECT * FROM livros WHERE genero LIKE '%$filtro%' OR titulo LIKE '%$filtro%' OR ano_publicacao LIKE '%$filtro%' OR autor LIKE '%$filtro%'";
    $sqlTotal = "SELECT COUNT(*) as total FROM livros WHERE genero LIKE '%$filtro%' OR titulo LIKE '%$filtro%' OR ano_publicacao LIKE '%$filtro%' OR fk_autor LIKE '%$filtro%'";
} else {
    $sql = "SELECT * FROM livros LIMIT $livrosPorPagina OFFSET $offset";
    $sqlTotal = "SELECT COUNT(*) as total FROM livros";
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
$totalResult = $conn->query($sqlTotal);
$totalLivros = $totalResult->fetch_assoc()['total'];
$totalPaginas = ceil($totalLivros / $livrosPorPagina);

echo "<div style='margin-top:10px;'>";
for ($i = 1; $i <= $totalPaginas; $i++) {
    if ($i == $pagina) {
        echo "$i ";
    } else {
        echo "<a href='?pagina=$i'>$i</a> ";
    }
}
echo "</div>";
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

echo "<form method='POST'>
        <button type='submit' name='emprestimos_cocluidos' value='todos'>Todos</button>
        <button type='submit' name='emprestimos_cocluidos' value='sim'>Concluídos</button>
        <button type='submit' name='emprestimos_cocluidos' value='nao'>Não Concluídos</button>
 </form>";

$concluidos = $_POST['emprestimos_cocluidos'] ?? 'todos';
$hoje = date('Y-m-d');
if ($concluidos == 'sim') {
    $sql = "SELECT id_emprestimo, data_emprestimo, data_devolucao,
               livros.titulo AS livro, leitores.nome AS leitor
        FROM emprestimos e
        JOIN livros ON fk_livro = id_livro
        JOIN leitores ON fk_leitor = id_leitor
        WHERE data_devolucao < '$hoje'";
} elseif ($concluidos == 'nao') {
    $sql = "SELECT id_emprestimo, data_emprestimo, data_devolucao,
               livros.titulo AS livro, leitores.nome AS leitor
        FROM emprestimos e
        JOIN livros ON fk_livro = id_livro
        JOIN leitores ON fk_leitor = id_leitor
        WHERE data_devolucao >= '$hoje'";
} else {
    $sql = "SELECT id_emprestimo, data_emprestimo, data_devolucao,
               livros.titulo AS livro, leitores.nome AS leitor
        FROM emprestimos e
        JOIN livros ON fk_livro = id_livro
        JOIN leitores ON fk_leitor = id_leitor";
}
$result = $conn->query($sql);

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
        $data_emprestimo = $row['data_emprestimo'];
        $data_emprestimo = date('d/m/Y', strtotime($data_emprestimo));
        $data_devolucao = $row['data_devolucao'];
        $data_devolucao = date('d/m/Y', strtotime($data_devolucao));
        echo "<tr>
        <td>{$row['id_emprestimo']}</td>
        <td>{$data_emprestimo}</td>
        <td>{$data_devolucao}</td>
        <td>{$row['livro']}</td>
        <td>{$row['leitor']}</td>
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