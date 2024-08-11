<main class="content">
    <?php
        renderTitle(
                "Registrar Ponto",
                "Mantenha seu ponto consistente!",
                "icofont-check-alt"
        );
        include TEMPLATE_PATH . "/messages.php";
    ?>
    <div class="card">
        <div class="card-header">
            <h3><?= $today ?></h3>
            <p class="mb-0">Os batimentos efetuados hoje</p>
        </div>
        <div class="card-body">
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 1: <?= array_key_exists('time1', $userWorkingHours->values) ? $userWorkingHours->time1 : '---' ?></span>
                <span class="record">Saída 1: <?= array_key_exists('time2', $userWorkingHours->values) ? $userWorkingHours->time2 : '---' ?></span>
            </div>
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 2: <?= array_key_exists('time3', $userWorkingHours->values) ? $userWorkingHours->time3 : '---' ?></span>
                <span class="record">Saída 2: <?= array_key_exists('time4', $userWorkingHours->values) ? $userWorkingHours->time4 : '---' ?></span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="#" class="btn btn-success btn-lg">
                <i class="icofont-check mr-1"></i>
                Bater o Ponto
            </a>
        </div>
    </div>
</main>