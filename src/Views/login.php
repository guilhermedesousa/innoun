<form class="form-login" action="#" method="post">
    <div class="login-card card">
        <div class="card-header">
            <i class="icofont-travelling mr-2"></i>
            <span class="font-weight-light">In</span>
            <span class="font-weight-bold mx-1">n'</span>
            <span class="font-weight-light">Out</span>
            <i class="icofont-runner-alt-1 ml-2"></i>
        </div>
        <div class="card-body">
            <?php include TEMPLATE_PATH . '/messages.php' ?>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control <?= array_key_exists('email', $errors) ? 'is-invalid' : '' ?>" placeholder="Informe o e-mail" autofocus value="<?= $email ?? '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('email', $errors) ? $errors['email'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" class="form-control <?= array_key_exists('password', $errors) ? 'is-invalid' : '' ?>" placeholder="Informe a senha">
                <div class="invalid-feedback">
                    <?= array_key_exists('password', $errors) ? $errors['password'] : '' ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-lg btn-primary w-100">Entrar</button>
        </div>
    </div>
</form>