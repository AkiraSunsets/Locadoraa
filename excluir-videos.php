<div class="container">
<h2>Excluir Vídeo</h2>
<?php
$idFilme = $_GET["idFilme"];
$sql = "delete from tbfilmes where idFilme = '{$idFilme}'";
$rs = mysqli_query($conexao,$sql);

echo "<p>Registro excluido com sucesso!</p>";

?>
</div>