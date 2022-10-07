<?php
require_once "config.php"; // eso es pa conectar este doc al fichero con el config, el cual incluye el puerto (8000)

include "gatos/list.php";
include "posts/list.php";
include "maullidos/list.php";

// siempre se incluye el doc index.php porque es el doc por defecto, cuando se abre en el navegador siempre va por defecto a index
