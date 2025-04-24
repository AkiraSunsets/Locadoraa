<h2>Atualizar Video</h2>
<?php
$idFilme = $_POST["idFilme"];
$tituloFilme = $_POST["tituloFilme"];
$duracaoFilme = $_POST["duracaoFilme"];
$valorLocacao = $_POST["valorLocacao"];
$idCategoria = $_POST["idCategoria"];

$sql = "update tbfilmes set 
tituloFilme='{$tituloFilme}',
duracaoFilme='{$duracaoFilme}',
valorLocacao='{$valorLocacao}',
idCategoria='{$idCategoria}' 
where idFilme = '{$idFilme}'
";
$rs = mysqli_query($conexao,$sql);
echo "<p>Registro atualizado com sucesso!</p>";
?>