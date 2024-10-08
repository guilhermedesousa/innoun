<main class="content">
    <?php
        renderTitle(
            'Relatório Mensal',
            'Acompanhe seu saldo de horas',
            'icofont-ui-calendar'
        );
    ?>
    <div>
        <form action="#" method="post" class="mb-4">
            <div class="input-group">
                <?php if ($user->is_admin): ?>
                    <select name="user" class="form-control mr-2">
                        <option value="">Selecione o usuário</option>
                        <?php
                        foreach ($users as $user) {
                            $selected = $user->id === $selectedUserId ? 'selected' : '';
                            echo "<option value='{$user->id}' {$selected}>{$user->name}</option>";
                        }
                        ?>
                    </select>
                <?php endif ?>
                <select name="period" class="form-control">
                    <?php
                    foreach ($periods as $key => $month) {
                        $selected = $key === $selectedPeriod ? 'selected' : '';
                        echo "<option value='{$key}' {$selected}>{$month}</option>";
                    }
                    ?>
                </select>
                <button class="btn btn-primary ml-2">
                    <i class="icofont-search"></i>
                </button>
            </div>
        </form>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <th>Dia</th>
                <th>Entrada 1</th>
                <th>Saída 1</th>
                <th>Entrada 2</th>
                <th>Saída 2</th>
                <th>Saldo</th>
            </thead>
            <tbody>
                <?php
                    foreach ($report as $registry): ?>
                        <tr>
                            <td><?= formatDateWithLocale($registry->work_date, '%B %d of %Y (%A)') ?></td>
                            <td><?= $registry->time1 ?></td>
                            <td><?= $registry->time2 ?></td>
                            <td><?= $registry->time3 ?></td>
                            <td><?= $registry->time4 ?></td>
                            <td><?= $registry->getBalance() ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="bg-primary text-white">
                        <td colspan="1">Horas Trabalhadas</td>
                        <td colspan="3"><?= $sumOfWorkedTime ?></td>
                        <td colspan="1">Saldo Mensal</td>
                        <td><?= $balance ?></td>
                    </tr>
            </tbody>
        </table>
    </div>
</main>