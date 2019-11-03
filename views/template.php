<!DOCTYPE html>
<html>
    <head>
        <title>EAD</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo BASE_URL; ?>assets/css/estilos.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="topo">
            <a href="<?php echo BASE_URL . "login/logOut" ?>">
                <div>Sair</div>
            </a>
            <div class="topoUsuario">
                <?php echo $viewData['info']->getNome(); ?>
            </div>
        </div>
        <div class="container">
            <?php $this->loadViewInTemplate($viewName, $viewData); ?> 
        </div>

        <script src="<?php echo BASE_URL; ?>assets/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>assets/js/script.js" type="text/javascript"></script>
    </body>
</html>