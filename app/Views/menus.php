<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menus</title>
</head>
<body>
    <h1>Menus Disponíveis</h1>
    <ul>
        <?php foreach ($menus as $menu): ?>
            <li><?= $menu ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="/">Voltar</a>
</body>
</html>