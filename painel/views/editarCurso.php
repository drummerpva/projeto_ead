<h1>Adicionar Curso - <?php echo $curso['nome']; ?></h1>
<form method="POST" enctype="multipart/form-data">
    Nome:<br/>
    <input type="text" name="nome" required value="<?php echo $curso['nome'] ?? ""; ?>"/><br/><br/>
    Imagem:<br/>
    <input type="file" name="imagem" /><br/>
    <img src="<?php echo BASE_URL; ?>../assets/images/cursos/<?php echo $curso['imagem'] ?? ""; ?>" width="150" /><br/><br/>
    Descrição:<br/>
    <textarea name="descricao" required><?php echo $curso['descricao'] ?? ""; ?></textarea><br/><br/>
    <input type="submit" value="Salvar"/>
</form>
<hr/>
<h2>Aulas</h2>
<fieldset>
    <legend>Adicionar Módulo</legend>
    <form method="POST">
        Nome do módulo:<br/>
        <input type="text" name="modulo" required />
        <input type="submit" value="Adicionar Módulo" />
    </form>
</fieldset><br/>
<fieldset>
    <legend>Adicionar Aula</legend>
    <form method="POST">
        Titulo da Aula:<br/>
        <input type="text" name="aula" required /><br/><br/>
        Módulo da Aula:<br/>
        <select name="moduloAula" required>
            <option selected disabled></option>
            <?php
            foreach ($modulos as $modA) {
                echo "<option value='{$modA['id']}'>{$modA['nome']}</option>";
            }
            ?>
        </select><br/><br/>
        Tipo da Aula:<br/>
        <select name="tipoAula" required>
            <option selected disabled></option>
            <option value="0">Video</option>
            <option value="1">Questionário</option>
        </select><br/><br/>
        <input type="submit" value="Adicionar Aula" />
    </form>
</fieldset>

<?php foreach ($modulos as $mod) {
    ?>
    <h4><?php echo $mod['nome']; ?> - <a href="<?php echo BASE_URL . "home/editarModulo/" . $mod['id']; ?>">[EDITAR]</a> - <a href="<?php echo BASE_URL . "home/delModulo/" . $mod['id']; ?>">[X]</a></h4>
    <?php foreach ($mod['aulas'] as $a) {
        ?>
        <h5>
        <?php echo $a['nome']; ?>
            - <a href="<?php echo BASE_URL . "home/editarAula/" . $a['id']; ?>">[EDITAR]</a> - <a href="<?php echo BASE_URL . "home/delAula/" . $a['id']; ?>">[X]</a>
        </h5>
        <?php
    }
    ?>
    <?php
}
?>