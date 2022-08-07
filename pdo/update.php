<?php 

require_once("conexao.php");


//MÉTODO PREPARE (UTILIZA PARAMETROS)

$res = $conexao->prepare("update clientes set nome = :n, telefone = :t where id = :id");

$res->bindValue(":n", "Marcela");
$res->bindValue(":t", "55854-8952");
$res->bindValue(":id", 1);
$res->execute();




//MÉTODO QUERY (NÃO UTILIZA PARAMETROS, VOCÊ PASSA DIRETO O VALOR DE FORMA RÁPIDA E PRÁTICA)
//$conexao->query("update clientes set nome = 'Hugo Freitas' where id = 1");


 ?>