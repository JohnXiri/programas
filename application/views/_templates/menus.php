
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>
<?php
if ($_SESSION ["admin"] == 'si') {
    $url=URL;
        $cate=$url."home/categorias/";
        $admin=$url."home/admin/";
        $users=$url."home/admin_usuarios/";
        $nueva=$url."home/admin_nueva_pagina/";
        $entradas=$url."home/ver_paginas/";
        $cate=$url."home/categorias/";
	print "<header>
	<nav>
	<ul>
	<li>
	<a href='$url'>Volver al Inicio</a>
	</li>
	<li>
	<a href='$admin'>Administración</a>
	</li>
	<li>
	<a href='$users'>Usuarios</a>
	</li>
	<li>
	<a href='$nueva'>Nuevo Artículo</a>
	</li>
        <li>
	<a href='$entradas'>Administrar entradas</a>
	</li>
	<li>
	<a href='$cate'>Categorias</a>
	</li>        
	</ul>	
	</nav>
	</header>";
}
?>
</body>
</html>