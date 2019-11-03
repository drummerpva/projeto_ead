<h1>Alunos</h1>
<a href="<?php echo BASE_URL . "alunos/adicionar" ?>">Adicionar Aluno</a><br/><br/>
<table>
    <tr>
        <th>Nome</th>
        <th>Qt Cursos</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($alunos as $aluno) {
        ?>
        <tr>
            <td width="200"><?php echo $aluno['nome']; ?></td>
            <td width="80" align="center"><?php echo $aluno['qtCursos']; ?></td>
            <td width="200">
                <a href="<?php echo BASE_URL . "alunos/editar/" . $aluno['id']; ?>">[ Editar ]</a>
                <a href="<?php echo BASE_URL . "alunos/excluir/" . $aluno['id']; ?>">[ Excluir ]</a>

            </td>
        </tr>

        <?php
    }
    ?>
</table>