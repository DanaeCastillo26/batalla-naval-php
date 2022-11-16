<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<h1 id="titulo"></h1>
	<select id="select_barco"></select>

<?php

/*
Batalla Naval

- Formulario de registro de jugadores
- Tablero de 10 x 10
- Buen diseño
- Colocar barcos de tamanio (3,2,2,1)
- Proceso con php
- Animación de Fallo o ataque
- Terminar el juego cuando a sun jugador no le queden barcos
- Mostrar resultados
- El juego debe estar en un repositorio
- El juego debe estar en un dominio 

:D Saludos
*/

$filas=10;
$columnas=10;

echo "<table>";
for($a=0; $a<$filas; $a++){
	echo "<tr>";
	for($b=0; $b<$columnas; $b++){
		echo "<td><div class='casilla' id='f".$a."c".$b."' onclick=\"ponerBarco({$a},{$b})\"></div></td>";
	}
	echo "</tr>";
}
echo "</table>";

?>
<button class="btn" onclick="aceptar()">Aceptar</button>

</body>
</html>

<script type="text/javascript">

var titulo=document.getElementById('titulo');
var selector=document.getElementById('select_barco');
var filas=10;
var columnas=10;
var turno=0;
var inicio=false;
var jugadores=[
	{
		nombre:`<?php echo $_POST['nombre1']; ?>`,
		barcos:[],
		disparos:[]
	},
	{
		nombre:`<?php echo $_POST['nombre2']; ?>`,
		barcos:[],
		disparos:[]
	}
];

titulo.innerHTML="Posición de barcos del jugador: "+jugadores[turno].nombre;
selector.innerHTML="<option value='1' id='select1' selected>Barco de 3</option>"+
		"<option value='2' id='select2'>Barco de 2</option>"+
		"<option value='3' id='select3'>Barco de 2</option>"+
		"<option value='4' id='select4'>Barco de 1</option>";
function aceptar(){
	if(selector.children.length>0){
		alert("Aún quedan barcos");
		return;
	}
	if(turno==0){
		turno=1;
		titulo.innerHTML="Posición de barcos del jugador: "+jugadores[turno].nombre;
		selector.innerHTML="<option value='1' id='select1' selected>Barco de 3</option>"+
		"<option value='2' id='select2'>Barco de 2</option>"+
		"<option value='3' id='select3'>Barco de 2</option>"+
		"<option value='4' id='select4'>Barco de 1</option>";
		this.resetearTablero();
	}else
	if(turno==1){
		iniciar();
	}
}

function tieneBarcos(turno){
	try{
		this.jugadores[turno].barcos.filter((barco)=>{
			barco.filter((coord)=>{
				if(!coord.disparo){
					throw true;
				}
			});
		});
		throw false;
	}catch(ex){
		return ex;
	}
}

function resetearTablero(){
	for(let a=0; a<filas; a++){
		for(let b=0; b<filas; b++){
			document.getElementById("f"+a+"c"+b).style.background="deepskyblue";
			this.jugadores[this.turnoOponente()].disparos.forEach((disparo)=>{
				if(a==disparo.fila && b==disparo.columna){
					document.getElementById("f"+disparo.fila+"c"+disparo.columna).style.background="red";
				}
			});
		}
	}
	this.jugadores[this.turnoOponente()].barcos.forEach((barco)=>{
		barco.forEach((coord)=>{
			if(coord.disparo){
				document.getElementById("f"+coord.fila+"c"+coord.columna).style.background="blue";
			}
		});
	});
}

function iniciar(){
	this.inicio=true;
	this.turno=0;
	titulo.innerHTML="Turno de "+jugadores[turno].nombre+" Atacando a "+jugadores[this.turnoOponente()].nombre;
	this.resetearTablero();
}

function turnoOponente(){
	return this.turno==0?1:0;
}

function ponerBarco(fila,columna){
	if(this.inicio){
		try{
			this.jugadores[this.turnoOponente()].disparos.push({'fila':fila,'columna':columna});
			this.jugadores[this.turnoOponente()].barcos.forEach((barco)=>{
				barco.forEach((coord)=>{
					if(coord.fila==fila && coord.columna==columna && !coord.disparo){
						document.getElementById("f"+fila+"c"+columna).style.background="blue";
						coord.disparo=true;
						throw true;
					}
				});
			});
			document.getElementById("f"+fila+"c"+columna).style.background="red";
			throw false;
		}catch(ex){
			if(ex){
				alert("Le diste a un barco :)");
			}else{
				alert("Fallaste el disparo :(");
			}
		}
		this.turno=this.turno==0?1:0;
		titulo.innerHTML="Turno de "+jugadores[turno].nombre+" Atacando a "+jugadores[this.turnoOponente()].nombre;
		if(!this.tieneBarcos(this.turnoOponente())){
			alert("Ha ganado el jugador "+this.jugadores[turno].nombre);
			document.location='index.php';
		}else{
			this.resetearTablero();
		}
		return;
	}
	var barco_select=Number(this.selector.value);
	switch(barco_select){
		case 1:{
			let casilla1=document.getElementById('f'+fila+'c'+columna);
			let casilla2=document.getElementById('f'+fila+'c'+(columna+1));
			let casilla3=document.getElementById('f'+fila+'c'+(columna+2));
			if(casilla1==null || casilla2==null || casilla3==null){
				alert("Posición no válida");
			}else{
				casilla1.style.background="black";
				casilla2.style.background="black";
				casilla3.style.background="black";
				document.getElementById('select'+barco_select).remove();
				this.jugadores[turno].barcos.push([
					{'disparo':false,'fila':fila,'columna':columna},
					{'disparo':false,'fila':fila,'columna':columna+1},
					{'disparo':false,'fila':fila,'columna':columna+2}
				]);
			}
			break;
		}
		case 2:{
			let casilla1=document.getElementById('f'+fila+'c'+columna);
			let casilla2=document.getElementById('f'+fila+'c'+(columna+1));
			if(casilla1==null || casilla2==null){
				alert("Posición no válida");
			}else{
				casilla1.style.background="black";
				casilla2.style.background="black";
				document.getElementById('select'+barco_select).remove();
				this.jugadores[turno].barcos.push([
					{'disparo':false,'fila':fila,'columna':columna},
					{'disparo':false,'fila':fila,'columna':columna+1}
				]);
			}
			break;
		}
		case 3:{
			let casilla1=document.getElementById('f'+fila+'c'+columna);
			let casilla2=document.getElementById('f'+fila+'c'+(columna+1));
			if(casilla1==null || casilla2==null){
				alert("Posición no válida");
			}else{
				casilla1.style.background="black";
				casilla2.style.background="black";
				document.getElementById('select'+barco_select).remove();
				this.jugadores[turno].barcos.push([
					{'disparo':false,'fila':fila,'columna':columna},
					{'disparo':false,'fila':fila,'columna':columna+1}
				]);
			}
			break;
		}
		case 4:{
			let casilla=document.getElementById('f'+fila+'c'+columna);
			if(casilla==null){
				alert("Posición no válida");
			}else{
				casilla.style.background="black";
				document.getElementById('select'+barco_select).remove();
				this.jugadores[turno].barcos.push([
					{'disparo':false,'fila':fila,'columna':columna}
				]);
			}
			break;
		}
		default: alert("No hay más barcos"); break;
	}
}

</script>