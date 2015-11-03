<?php
$_SESSION['action'] = 'handleGetFlies';
?>

<h1>Generar csv de los productos obtenidos</h1>

<form action="../controllers/ProsessFile.php" method="POST">

    <div>
        <p>Opciones para exportar :</p>
        <select name="programOptions">
            <option value="1">Descargar csv de productos y lotes de imagenes</option>
        </select>
    </div>

    <div>
        <p>Delimitador de columna :
            <select name="csvDelimiter">
                <option value=",">,</option>
                <option value=":">:</option>
                <option value="|">|</option>
            </select>
        </p>
    </div>
    <div>
        <p>items por lote :
            <select name="numItems">
                <?php for($i = 1; $i<=4; $i++): ?>
                  <option value="<?=$i*5 ?>"><?=$i*5 ?></option>
                <?php endfor; ?>
            </select>
        </p>
    </div>

    <p>para descargar datos:
        <input type="submit">
    </p>

</form>
