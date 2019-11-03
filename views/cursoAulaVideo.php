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
        <?php foreach ($mod['aulas'] as $au) {
            ?>
            <a href="<?php echo BASE_URL . "cursos/aula/" . $au['id'] ?>"><div class="aula"><?php echo $au['nome']; ?><?php echo ($au['assistida']) ? " <img src='".BASE_URL."assets/images/v.png' width='12'/>" : "";?></div></a>
            <?php
        }
        ?>
        <?php
    }
    ?>
</div>
<div class="cursoRight">
    <h1>Vídeo - <?php echo $aula['nome']; ?></h1>
    <iframe id="video" style="width:100%;" src="//player.video.com/video/<?php echo $aula['url']; ?>"></iframe><br/>
    <?php echo $aula['descricao']; ?><br/>
    <button onclick="marcarAssistida(this);" data-id="<?php echo $aula['id_aula'];?>" <?php echo ($aula['assistida']) ? "disabled >Assistida" : ">Marcar como assistida";?></button>
    
    <hr/>
    <h3>Dúvidas? Envie sua pergunta!</h3>
    <form method="POST" class="formDuvida">
        <textarea name="duvida"></textarea><br/><br/>
        <input type="submit" value="Enviar Dúvida" />
    </form>
</div>