<?php
session_start();
if(isset($_SESSION["username"]))
{
?>
<html>
    <head>
        <title>Hertz Game</title>
        <meta charset="utf-8">
		
		<script>
			
			var selectD;
			var selectT;
			
			//FUNZIONE PER NAVIGARE TRA LE PAGINE DEL MENU'
			function navigate(x)
			{
				var main = document.getElementById("main");
				var dif = document.getElementById("difficolta");
				var topic = document.getElementById("argomento");
				switch(x)
				{
					case 0:
						main.style.display="none";
						dif.style.display="block";
						document.getElementById("body").style.backgroundImage = "url('immagini/modsel.png')";
					break;
					
					case 1:
						document.getElementById("body").style.backgroundImage = "none";
						document.getElementById("body").style.backgroundColor = "blue";
						main.style.animationDelay="0s";
						dif.style.display="none";
						if(topic.style.display = "block")
							topic.style.display = "none";
						if(document.getElementById("invia").style.display = "block")
							document.getElementById("invia").style.display="none";
						main.style.display="block";
					break;
				}
			}
			
			
			//FUNZIONE PER SCELTA DIFFICOLTA
			function diff(x)
			{
				selectD = x;
				if(document.getElementById("argomento").style.display = "none")
					document.getElementById("argomento").style.display = "block";
			}
			
			//FUNZIONE PER SCELTA DIFFICOLTA E ARGOMENTO 
			function topic(x)
			{
				selectT = x;
				if(document.getElementById("invia").style.display = "none")
					document.getElementById("invia").style.display="block";
			}
			
			//FUNZIONE PER INVIARE DATI A GAME.PHP
			function invia()
			{
				window.location.href = "/tesina/progetto/game.php?dif="+selectD+"&topic="+selectT+" ";				 
			}
			
			
		</script>
		
		<style>
			
		
			/* CSS BODY */
			#body
			{
				background-color:orange;
				background-repeat= no-repeat;
				background-position = cover;
				background-size: 100% 100%;
			}
		
			/* CSS ANIMATION NASCONDI */
			@-webkit-keyframes trasparence {
				0% {
				opacity:1);
				}
				100% {
				opacity:0;
				display:none;
				}
			}
			
			@-moz-keyframes trasparence {
				0% {
				opacity:1
				);
				}
				100% {
				opacity:0;
				display:none;
				}
			}

			/* CSS SCHERMATA INTRODUTTIVA */
			#benvenuti{
            	text-shadow:2px 2px white;
				width: 100%;
				font-size: 72px;
				text-align: center;
				background-color: orange;
				animation-name: trasparence;
				animation-duration: 4s;
				animation-fill-mode: forwards;
			}
			
			/* CSS ANIMATION DISPLAY */
			@-webkit-keyframes display
			{
				0% {
				opacity:0);
				}
				100% {
				opacity:1;
				}
			}
			
			@-moz-keyframes display
			{
				0% {
				opacity:0);
				}
				100% {
				opacity:1;
				}
			}
			
			/* CSS MAIN MENU'*/
			#main
			{
            	font-family:Verdana;
                text-shadow:3px 3px black;
				opacity:0;
				width: 100%;
				height: 100%;
				position: absolute;
				top:0;
				left:0;
				background-color: blue;
				animation-name: display;
				animation-duration: 2s;
				animation-delay: 2s;
				animation-fill-mode: forwards;
			}
			
			/* CSS BOTTONE START */
			#main button
			{
				font-size: 64px;
                text-shadow:3px 3px black;
                font-family:Verdana;
                color:orange;
				position: absolute;
				top: 25%;
				left:40%;
				right:40%;
				border-color: rgba(0,0,0,0);
				background-color: rgba(0,0,0,0);
			}
			
			/* CSS HREF INFORMAZIONI */
			#info
			{
				font-size: 32px;
				position: absolute;
				left:10%;
				bottom:20%;
				text-decoration: none;
				color: orange;
			}	
			
			/* CSS HREF HIGH SCORES */
			#hs
			{
            	display:none;
				font-size: 32px;
				position:absolute;
				right:10%;
				bottom:20%;
				text-decoration: none;
				color: orange;
			}
			
			
			/* CSS MENU SCELTA DIFFICOLTA */
			#difficolta
			{
             margin:auto;
			 display:none;
			 opacity:0;
			 width: 100%;
			 height: 100%;
             max-width: 100%;
			 max-height: 100%;
             background-repeat:no-repeat;
			 background-size: 100% 100%;
			 animation-name: display;
			 animation-duration: 2s;
			 animation-fill-mode: forwards;
			}
			
			/* CSS SCELTA ARGOMENTO */
			#argomento
			{
             margin:auto;
			 display:none;
			 width: 100%;
			 height: 100%;
			 position: absolute;
			 top:0;
			 right:0;
			 animation-name: display;
			 animation-duration: 2s;
			 animation-fill-mode: forwards;
			}
		
			
			/* CSS PULSANTE BACK */
			.back
			{
            	max-width:10%;
            	max-height:10%;
				position:absolute;
				left:1%;
				top:5%; 
			}
			
			/* CSS PULSANTI SELEZIONE MODALITA */
			.level
			{
				border-color: rgba(0,0,0,0);
				background-color: rgba(0,0,0,0);
				font-size: 60px;
			}
			
			.argom
			{
				border-color: rgba(0,0,0,0);
				background-color: rgba(0,0,0,0);
				font-size: 54px;
				position: absolute
			}
			
			/* CSS PULSANTE EASY */
			#easy
			{
				position: absolute;
				top: 50%;
				left:6%;
			}
			
			/* CSS PULSANTE MEDIUM */
			#medium
			{
				position: absolute;
				top: 65%;
				left:6%;
			}
			
			/* CSS PULSANTE HARD */
			#hard
			{
				position: absolute;
				top: 80%;
				left:6%;
			}
			
			
			
			/* ARGOMENTI */			
			#SPORT
			{
				position:absolute;
				top:0%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}

      #STORIA
			{
				position:absolute;
				top:9%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}

      #SCIENZA
			{
				position:absolute;
				top:18%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}
			
			#RANDOM
			{
				position:absolute;
				top:27%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}

      #LINGUAINGLESE
			{
				position:absolute;
				top:36%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}
			

      #TECNOLOGIA
			{
				position:absolute;
				top:45%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}

      #MATEMATICA
			{
				position:absolute;
				top:54%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}

      #INTRATTENIMENTO
			{
				position:absolute;
				top:63%;
				right: 8%;
				opacity:0;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}
			
			
			#invia
			{
				display: none;
				position:absolute;
				bottom:8%;
				right: 8%;
				opacity:0;
				border-color: rgba(0,0,0,1);
				background-color: rgba(255,255,255,0);
				font-size: 54px;
				animation-name: display;
				animation-duration: 2s;
				animation-fill-mode: forwards;
			}
		</style>
    </head>

	<body id="body">
		<div id="benvenuti">
			<h1> Benvenuti in <br> Hertz Game! </h1>
		</div>
		
		<div align="center" id="main">
		    <button onclick="navigate(0)"> INIZIA </button>
			<a href="PresentazioneHertzGame.html" id="info">Info </a>
			<a href="highscores.php" id = "hs">High Scores </a>
		</div>
		
		
		
		<div id="difficolta">
			<img src="immagini/freccia.png" class="back" onclick="navigate(1)">
			<button class = "level" id ="easy" onclick="diff(4)"> FACILE </button>
			<button class = "level" id ="medium" onclick="diff(3)"> MEDIO </button>
			<button class = "level" id ="hard" onclick="diff(2)"> DIFFICILE </button>
		
			<div id="argomento">
			<img src="immagini/freccia.png" class="back" onclick="navigate(1)">
			<button class = "argom" id ="LINGUAINGLESE" onclick="topic('LANGUAGE')"> LANGUAGE </button>
			<button class = "argom" id ="SCIENZA" onclick="topic('SCIENZA')"> SCIENZA </button>
			<button class = "argom" id ="INTRATTENIMENTO" onclick="topic('INTRATTENIMENTO')"> INTRATTENIMENTO </button>
			<button class = "argom" id ="TECNOLOGIA" onclick="topic('TECNOLOGIA')"> TECNOLOGIA </button>
			<button class = "argom" id ="MATEMATICA" onclick="topic('MATEMATICA')"> MATEMATICA </button>
			<button class = "argom" id ="STORIA" onclick="topic('STORIA')"> STORIA </button>
			<button class = "argom" id ="SPORT" onclick="topic('SPORT')"> SPORT </button>
			<button class = "argom" id ="RANDOM" onclick="topic('RANDOM')"> RANDOM </button>
			<button id ="invia" onclick="invia()"> START </button>
			</div>
			
			
		</div>
			

    </body>
</html>
<?php
}
else
{
	echo "<script>alert('DEVI EFFETTUARE IL LOGIN')</script>";
    header( "refresh:0; url=http://manueldilullotesina.altervista.org/tesina/progetto/login.php");
}
?>
