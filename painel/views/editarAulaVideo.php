<h1>Editar Aula - Vídeo</h1>
<form method="POST" >
    Titulo da aula:<br/>
    <input type="text" name="nome" required value="<?php echo $aula['nome'];?>"/><br/><br/>
    Descrição:<br/>
    <textarea name="descricao" ><?php echo $aula['descricao'];?></textarea><br/><br/>
    URL vídeo:<br/>
    <input type="text" name="url" value="<?php echo $aula['url'];?>"/><br/><br/>
    <input type="submit" value="Salvar"/>
</form>