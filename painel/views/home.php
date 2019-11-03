<h1>Cursos</h1>
<a href="<?php echo BASE_URL . "home/adicionar" ?>">Adicionar Curso</a><br/><br/>
<table >
    <tr>
        <th>Imagem</th>
        <th>Nome</th>
        <th>Qt Alunos</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($cursos as $curso) {
        ?>
        <tr>
            <td width="100"><img src="<?php echo BASE_URL . "../assets/images/cursos/" . $curso['imagem']; ?>" height="70"/></td>
            <td width="200"><?php echo $curso['nome']; ?></td>
            <td width="80" align="center"><?php echo $curso['qtAlunos']; ?></td>
            <td width="200">
                <a href="<?php echo BASE_URL . "home/editar/".$curso['id']; ?>">[ Editar ]</a>
                <a href="<?php echo BASE_URL . "home/excluir/".$curso['id']; ?>">[ Excluir ]</a>

            </td>
        </tr>

        <?php
    }
    ?>
</table>