<h1>Editar Aluno</h1>
<form method="POST" >
    Nome:<br/>
    <input type="text" name="nome" required value="<?php echo $aluno['nome'] ?? ""; ?> "/><br/><br/>
    Email:<br/>
    <input type="email" name="email" disabled value="<?php echo $aluno['email'] ?? ""; ?> "/><br/><br/>
    Senha:<br/>
    <input type="password" name="senha"  /><br/><br/>
    Cursos inscritos: (Segure CTRL para selecionar vários cursos)<br/>
    <select name="cursos[]" multiple style="height:150px;">
        <option value="0">--- Nenhum ---</option>
        <?php foreach ($cursos as $curso) {
        ?>
        <option value="<?php echo $curso['id'];?>" <?php echo (in_array($curso['id'],$inscritos)) ? "selected" : "";?>><?php echo $curso['nome'];?></option>
        <?php
        }
        ?> 
    </select><br/><br/>
    <input type="submit" value="Salvar"/>
</form>