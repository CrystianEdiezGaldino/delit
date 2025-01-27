<form action="<?= site_url('auth') ?>" method="post">
    <label for="ime">IME:</label>
    <input type="text" name="ime" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" name="senha" required>
    <br>
    <button type="submit">Entrar</button>
</form>