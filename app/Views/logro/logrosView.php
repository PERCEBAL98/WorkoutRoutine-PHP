<?php include("templates/parte1.php"); ?>
<main id="contenido" class="expanded">
    <div class="container-fluid info-rutina mt-1">
        <?php foreach ($datos as $nombreLogro => $logrosPorNombre) { ?>
            <div class="logro">
                <h3 class="mt-1 mb-3"><?= $nombreLogro; ?></h3>
                <div class="mt-2 mb-2 row">
                    <?php foreach ($logrosPorNombre as $index => $logro) {
                        $canvasId = strtolower(str_replace(' ', '_', $nombreLogro)) . '_nivel_' . $logro['nivel_logro'];
                    ?>
                        <div class="col-12 col-xl-4 mb-3 text-center">
                            <div class="canvas-container">
                                <h5>
                                    <?php if ($logro['nivel_logro'] == 1){?>
                                        Fácil
                                    <?php } elseif ($logro['nivel_logro'] == 2) { ?>
                                        Normal
                                    <?php } elseif ($logro['nivel_logro'] == 3) { ?>
                                        Difícil
                                    <?php } ?>
                                </h5>
                                <canvas id="<?= $canvasId ?>"></canvas>
                                <p><?= $nombreLogro; ?> : <?= $logro['puntos_actuales']; ?>/<?= $logro['puntos_maximos']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</main>
<?php include("templates/parte2.php"); ?>