<h1>Seus Cursos</h1>
<?php foreach($cursos as $curso){
    ?>
<a href="<?php echo BASE_URL."cursos/entrar/".$curso['id']?>">
<div class="cursoItem">
    <img src="<?php echo BASE_URL."assets/images/cursos/".$curso['imagem'];?>" width="255" height="150"/><br/><br/>
    <b><?php echo $curso['nome'];?></b><br/><br/>
    <?php echo $curso['descricao'];?>
    
</div>
</a>
        <?php
}
?>