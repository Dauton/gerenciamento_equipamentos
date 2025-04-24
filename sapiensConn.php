<?php
// Conexão com o banco de dados
$host = "10.60.253.20"; // ou IP do servidor
$opcoes = [
    "Database" => "sapiens",
    "Uid" => "consulta",
    "PWD" => "@dM1324",
    "TrustServerCertificate" => true, // <- aqui está o segredo!
    "Encrypt" => true
];

$conn = sqlsrv_connect($host, $opcoes);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Executa a consulta
$sql = "SELECT * FROM USU_TCADFUN WHERE USU_DESSIT = 'Ativo' ORDER BY USU_NOMFUN";
$query = sqlsrv_query($conn, $sql);

if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Percorre os resultados
while ($usuario = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    echo $usuario['usu_nomfun'] . "<br>"; // Substitua 'nome' por a coluna que quiser
}

// Fecha a conexão
sqlsrv_close($conn);
?>
