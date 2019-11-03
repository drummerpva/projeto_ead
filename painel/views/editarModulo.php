<h1>Editar Módulo</h1>
<form method="POST">
    Nome do módulo:<br/>
    <input type="text" name="modulo" required value="<?php echo $modulo['nome'] ?? ""; ?>"/><br/><br/>
    <input type="submit" value="Salvar"/>
</form>