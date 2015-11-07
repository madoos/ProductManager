<?php
$_SESSION['action'] = 'index';
?>
    <div>
        <h1>
            Configuracion de los campos del producto
        </h1>
        <form action="../controllers/SearchProducts.php" method="POST">

            <select name="programOptions">
                <option value="1">Obtener imagenes que se alojan en un servidor diferente de esta pagina</option>
                <option value="2">Obtener imagenes desde atributo css</option>
                <option value="3">Web normales</option>
            </select>

            <p>url base de las imagenes<input type="text" name="imgUrlBase"></p>

            <p>Escriba las xpaht querys en los respectivos campos.</p>

            <p>Prefijo del id del producto:  <input type="text" name="prefix"> </p>
            <p>Xpath query de el nombre:  <input type="text" name="queryName"> </p>
            <p>Xpath query de la descripcion: <input type="text" name="queryDescription"> </p>
            <p>Xpath query de la especificaciones:  <input type="text" name="querySpecifications"> </p>
            <p>Xpath query de el precio:  <input type="text" name="queryPrice"> </p>

            <p>Ejemplo de query para imagenes "//img[@class='product-hero-image']/@src"</p>
            <p>Xpath query delas imagenes:  <input type="text" name="queryImages"> </p>

            <input type="submit">
        </form>
    </div>


