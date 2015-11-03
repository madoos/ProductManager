<?php
$_SESSION['action'] = 'uploadFile';
?>
<div>
    <h1>
        Seleccion los csv de los culaes quiere crear combinaciones
    </h1>
    <p>Seleccione:</p>
    <form action="../controllers/productCombination.php" method="post" enctype="multipart/form-data">
        <input type="file" name="filesCsv[]" id="fileCsv" multiple="multiple">
        <input type="submit" value="Subir archivo">
    </form>
</div>