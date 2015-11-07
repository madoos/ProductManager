<?php
$_SESSION['action'] = 'saveProducts';
?>
<div>
    <h1>Ejemplo de los datos del producto.</h1>

        <form action="../controllers/SearchProducts.php" method="POST">
           <p>Si esta conforme con el resultado : <input type="submit"> </p>
        </form>

    <div id="product">

        <h1> <?php echo $_SESSION['products'][1]['name']; ?> </h1>
        <p>precio: <br><?php echo $_SESSION['products'][1]['price']; ?>  </p>
        <br>
        <br>
        <p>descripcion:<br> <?php echo $_SESSION['products'][1]['description']; ?>  </p>
        <br>
        <br>
        <p>especificaciones:<br> <?php echo $_SESSION['products'][1]['specifications']; ?>  </p>
        <br>
        <br>

        <div>
            <h1>IMAGENES</h1>
            <?php    var_dump($_SESSION['products'][1]) ?>
            <?php foreach( $_SESSION['products'][1]['images'] as $image): ?>
                <img src="<?= $image ?>">
            <?php endforeach; ?>
        </div>
    </div>
</div>
