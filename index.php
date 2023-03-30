<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adicionar/Retornar Usuário</title>
</head>
<body>
    <?php
        // Lógica da API (Model)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = array(
                'cpf' => $_POST['cpf'],
                'nome' => $_POST['nome'],
                'data_nascimento' => $_POST['data_nascimento']
            );
            $usuarios = array();
            if (file_exists('usuarios.json')) {
                $usuarios = json_decode(file_get_contents('usuarios.json'), true);
            }
            $usuarios[] = $usuario;
            file_put_contents('usuarios.json', json_encode($usuarios));
            echo "<p>Usuário adicionado com sucesso!</p>";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $cpf = $_GET['cpf'];
            $usuarios = array();
            if (file_exists('usuarios.json')) {
                $usuarios = json_decode(file_get_contents('usuarios.json'), true);
            }
            $usuario = array_filter($usuarios, function($u) use($cpf) {
                return $u['cpf'] == $cpf;
            });
            if (!empty($usuario)) {
                $usuario = reset($usuario);
                echo "<p>CPF: {$usuario['cpf']}</p>";
                echo "<p>Nome: {$usuario['nome']}</p>";
                echo "<p>Data de Nascimento: {$usuario['data_nascimento']}</p>";
            } else {
                echo "<p>Usuário não encontrado!</p>";
            }
        }
    ?>
    <!-- Interface do Usuário (View) -->
    <h1>Adicionar/Retornar Usuário</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required><br><br>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required><br><br>
        <input type="submit" value="Adicionar">
    </form>
    <br>
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required><br><br>
        <input type="submit" value="Retornar">
    </form>
</body>
</html>
