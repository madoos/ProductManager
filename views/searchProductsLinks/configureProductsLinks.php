<?php
$_SESSION['action'] = 'handleGetLinks';
?>
    <div>
        <h1>
          Obtener todas las url de una pagina web.
        </h1>
        <div>
            <p>Para obtener las urls de los productos copie y pegue este codigo js en la consola de su navegador , recuerde poner el SELECTOR JQUERY que contiene esos elementos.</p>

            <pre class="prettyprint lang-js">

                var jq = document.createElement('script');
                jq.src = "//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js";
                document.getElementsByTagName('head')[0].appendChild(jq);
                jQuery.noConflict();
            </pre>

            <pre class="prettyprint lang-js">

                function uniq(a) {
                    var prims = {"boolean":{}, "number":{}, "string":{}}, objs = [];
                    return a.filter(function(item) {
                        var type = typeof item;
                        if(type in prims)
                            return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
                        else
                            return objs.indexOf(item) >= 0 ? false : objs.push(item);
                    });
                }
            </pre>

            <pre class="prettyprint lang-js">

                var result = [];
                //SELECTOR NOMBRE DE LA CLASE O ID.
                var products = $('.SELECTOR a').map(function(){  return $(this).attr('href') }).each(function(index,element){ result.push(element)});
                uniq(result);
            </pre>
        </div>

        <form action='../controllers/searchProductsLinks.php' method="POST">
            <h1>Opciones del programa</h1>

            <select name="programOptions">
                <option value="1">Obtener links con js</option>
                <option value="2">Obtener links desde una categoria</option>
                <option value="3">Obtener links de varias  categoria</option>
                <option value="4">Obtener links desde la url de la pagina</option>
                <option value="5">Obtener links de categoria paginada</option>
            </select>

            <p>Pegue aqui los links de las categorias o productos separados por coma (,).</p>

            <textarea name="textProductLinks"></textarea>

            <p>Configuracion.</p>

            <p>Url de la pagina : <input type="text" name="urlPage"></p>
            <p>Url base : <input type="text" name="urlBase"></p>
            <p>Xpath de la clase de las categorias o productos :  <input type="text" name="className"></p>

            <p>Numero de paginas:
                <input type="text"  name="nunPages">
               Nombre de la variable de paginacion:
                <input type="text"  name="nameVarPages">
            </p>

            <input type="submit">
        </form>
    </div>




