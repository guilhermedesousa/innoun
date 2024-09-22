<main class="content">
    <?php
        renderTitle(
            'Cadastro de Usuário',
            'Crie ou atualize o usuário',
            'icofont-user'
        );

        include(TEMPLATE_PATH . "/messages.php");
    ?>

    <form action="#" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Informe o nome" class="form-control <?= array_key_exists('name', $errors) ? 'is-invalid' : '' ?>" value="<?= $name ?? '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('name', $errors) ? $errors['name'] : '' ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="Informe o e-mail" class="form-control <?= array_key_exists('email', $errors) ? 'is-invalid' : '' ?>" value="<?= $email ?? '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('email', $errors) ? $errors['email'] : '' ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Informe a senha" class="form-control <?= array_key_exists('password', $errors) ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('password', $errors) ? $errors['password'] : '' ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="confirm_password">Confirme a senha</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirme a senha" class="form-control <?= array_key_exists('confirm_password', $errors) ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('confirm_password', $errors) ? $errors['confirm_password'] : '' ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="start_date">Data de admissão</label>
                <input type="date" name="start_date" id="start_date" class="form-control <?= array_key_exists('start_date', $errors) ? 'is-invalid' : '' ?>" value="<?= $start_date ?? '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('start_date', $errors) ? $errors['start_date'] : '' ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="end_date">Data de desligamento</label>
                <input type="date" name="end_date" id="end_date" class="form-control <?= array_key_exists('end_date', $errors) ? 'is-invalid' : '' ?>" value="<?= $end_date ?? '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('end_date', $errors) ? $errors['end_date'] : '' ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="is_admin">Administrador?</label>
                <input type="checkbox" name="is_admin" id="is_admin" class="d-block <?= array_key_exists('is_admin', $errors) ? 'is-invalid' : '' ?>" value="<?= $is_admin ? 'checked' : '' ?>">
                <div class="invalid-feedback">
                    <?= array_key_exists('is_admin', $errors) ? $errors['is_admin'] : '' ?>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-primary btn-lg">Salvar</button>
            <a href="/users.php" class="btn btn-secondary btn-lg">Cancelar</a>
        </div>
    </form>
</main>