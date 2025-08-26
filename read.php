<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Livros</h2><br>";
    $sql_ = "SELECT * FROM livros";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "$row[id_livro]";
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read</title>
</head>
<body>
    <form method="POST">
        
    </form>
</body>
</html>