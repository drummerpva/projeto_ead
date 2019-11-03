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
    <h1>Questionário</h1>
    <?php
    if ($_SESSION['poll' . $aula['id_aula']] > 2) {
        echo "Você atingiu o limite de tentativas!";
    } else {
        echo "Tentativa: " . $_SESSION['poll' . $aula['id_aula']] . " de 2";
        ?>
        <h3><?php echo $aula['pergunta']; ?></h3>
        <form method="POST">
            <label><input type="radio" name="opcao" value="1" id="opcao1"/><?php echo $aula['opcao1']; ?></label><br/><br/>
            <label><input type="radio" name="opcao" value="2" id="opcao2"/><?php echo $aula['opcao2']; ?></label><br/><br/>
            <label><input type="radio" name="opcao" value="3" id="opcao3"/><?php echo $aula['opcao3']; ?></label><br/><br/>
            <label><input type="radio" name="opcao" value="4" id="opcao4"/><?php echo $aula['opcao4']; ?></label><br/><br/>
            <input type="submit" value="Enviar Resposta"/>
        </form>
        <?php
        if (isset($resposta)) {
            if ($resposta) {
                echo "<h4>Resposta Correta!</h4>";
            } else {
                echo "<h4>Resposta Incorreta, tente novamente!</h4>";
            }
        }
    }
    ?>
</div>