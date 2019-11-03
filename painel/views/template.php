<!DOCTYPE html>
<html>
    <head>
        <title>EAD - Administração</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo BASE_URL; ?>assets/css/estilos.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="topo">
            
            <a href="<?php echo BASE_URL;?>">
                <div>Cursos</div>
            </a>
            <a href="<?php echo BASE_URL."alunos";?>">
                <div>Alunos</div>
            </a>
            <a href="<?php echo BASE_URL . "login/logOut" ?>">
                <div style="float:right;">Sair</div>
            </a>
        </div>
        <div class="container">
            <?php $this->loadViewInTemplate($viewName, $viewData); ?> 
        </div>

        <script src="<?php echo BASE_URL; ?>assets/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>assets/js/script.js" type="text/javascript"></script>
    </body>
</html>