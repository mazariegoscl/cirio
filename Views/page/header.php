<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="src/css/fontawesome-all.css">
	<link rel="stylesheet" href="src/css/jquery-ui.css">
	<link rel="stylesheet" href="src/css/jquery-ui.theme.css">
	<link rel="stylesheet" href="src/css/jquery-ui.structure.css">
	<link rel="stylesheet" href="src/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="src/js/jquery-ui.js"></script>
    <script src="src/js/nav.js"></script>
    <script src="src/js/index.js"></script>
	<title>Cirio Panel</title>
</head>
<body>
	<header>
		<div class="title-header">EL CIRIO - Administración</div>
		<a class="logout-header" href="users/logout">Cerrar sesión</a>
	</header>
	<div class="burger-button"><i class="fa fa-bars"></i></div>
	<nav>
		<div class="nav-wrapper">
			<ul>
				<li><a href="home">Dashboard</a></li>
				<li><a href="reservations">Reservaciones</a></li>
				<li class="sub"><a class="inactive" href="#">Reportes</a>
					<ul>
						<li><a href="sales">Ventas</a></li>
						<li><a href="expenses">Gastos</a></li>
						<!--<li><a href="#">Gastos</a></li>-->
						<li><a href="commissions">Comisiones</a></li>
					</ul>
				</li>
				<li class="sub"><a class="inactive" href="#">Inventario</a>
					<ul>
						<li><a href="propertyInventory">Propiedad</a></li>
						<li><a href="inventory">Operativo</a></li>
					</ul>
				</li>
				<li class="sub"><a class="inactive" href="#">Administrar Propiedades</a>
					<ul>
						<li><a href="properties">Lista de Propiedades</a></li>
						<li><a href="expensesType">Tipos de Gastos</a></li>
						<li><a href="categoryExpenses">Categorías de gastos</a></li>
					</ul>
				</li>
                <li><a href="configuration">Configuración</a></li>
			</ul>
		</div>
	</nav>
	<main>
