<?php
$_SESSION['action']= 'saveProductsLinks';
?>
<div>
    <h1>
        Total de productos encontrados en la web : <?php echo count($_SESSION['data'])?>
    </h1>

    <p>
        Compruebe que los links obtenidos son correctos y estan bien formados haciendo click.
    </p>

    <div  style="width: 730px; height: 400px; overflow-y: scroll;">
        <?php
            $aList ="";
            foreach( $_SESSION['data'] as $link ){
                $aList .= "<a href=$link  target='_blank'> $link </a><br>";
            }
            echo $aList;
        ?>
    </div>

    <p>
        Si esta conforme presione el boton para guardar los datos.
    </p>

    <form action="../controllers/searchProductsLinks.php" method="POST">
        <input type="submit" value="guardar datos">
    </form>


</div>


