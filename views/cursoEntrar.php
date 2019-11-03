<div class="cursoInfo">
    <img src="<?php echo BASE_URL . "assets/images/cursos/" . $curso->getImagem(); ?>" height="60px"/>
    <h3><?php echo $curso->getNome(); ?></h3>
    <?php echo $curso->getDescricao(); ?><br/>
    <?php echo $aulasAssistidas." de ".$totalAulas."(".number_format((($aulasAssistidas/$totalAulas)*100),0,"","")."%) Assistidas";?>
</div>
<div class="cursoLeft">
    <?php foreach ($modulos as $mod) {
        ?>
        <div class="modulo"><?php echo $mod['nome']; ?></div>
        <?php foreach ($mod['aulas'] as $aula) {
            ?>
        <a href="<?php echo BASE_URL."cursos/aula/".$aula['id'];?>"><div class="aula"><?php echo $aula['nome'];?><?php echo ($aula['assistida']) ? " <img style='float:right; margin-right:10px;margin-top:7px;' src='".BASE_URL."assets/images/v.png' width='15'/>" : "";?></div></a>
            <?php
        }
        ?>
        <?php
    }
    ?>
</div>
<div class="cursoRight">

</div>