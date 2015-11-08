<?php
require_once('../config.php');
//crear helper path!
require_once('../helpers/HelperPath.php');
set_time_limit(0);
?>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>
           Product Manager
        </title>
    </head>
    <body>
        <div id="content">
            <?php
                $pathView = $_SESSION['__pathView'];
                require_once(".$pathView.php");
            ?>
        </div>
    </body>
</html>