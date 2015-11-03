<?php
$_SESSION['sizes'] = ['S','M','L','XL'];
$_SESSION['cuadros'] = [49,52,54,56,58];
$_SESSION['action'] = 'generateCombinations';
?>


<div>

    <h1>
        Configurar tallas y colores

    </h1>

    <div>
        <h1>Informacion de los ficheros subidos </h1>
        <?php
            var_dump($_SESSION['data']);
        ?>

    </div>

    <form action="../controllers/productCombination.php" method="post">
        <div>
            <h1>Selecione tallas</h1>
        </div>

        <div>
            <p>Selecione tallas</p>
            <?php foreach($_SESSION['sizes'] as $size):?>
                <span><?= $size ?></span>
                <input type="checkbox" name="sizes[]" multiple value="<?= $size ?>">
            <?php endforeach; ?>
        </div>


        <div>
            <p>Selecione cuadros</p>
            <?php foreach($_SESSION['cuadros'] as $cuadro):?>
                <span><?= $cuadro ?></span>
                <input type="checkbox" name="cuadros" value="<?= $cuadro ?>">
            <?php endforeach; ?>
        </div>


        <input type="submit" value="Crear fichero de combinaciones">
    </form>



</div>