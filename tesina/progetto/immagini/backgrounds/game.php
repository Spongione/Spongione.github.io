<html>
	<head>
		<meta charset="UTF-8">
		<title> HERTZ GAME </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
		
		<script>
        	
			var correctAns;								//RISPOSTA CORRETTA ESTRATTA DAL DB
			var tempoRisp;								//TEMPO RISPOSTA
			var buttonAns;								//NUMERO BOTTONE PREMUTO 
			var punteggio;								//PUNTEGGIO RAGGIUNTO CON LA RISPOSTA
			var timetotal;								//TEMPO PER RISPOSTA
			var timeleft;								//TEMPO RIMANENTE PER TIMER
			var turno;									//FLAG PER TURNO PLAYER/ENEMY
			var playerHealth;							//SALUTE DEL GIOCATORE
			var enemyHealth;							//SALUTE DELLA CPU 
			var width = window.innerWidth;				//LARGHEZZA FINESTRA
			var height = window.innerHeight;			//ALTEZZA FINESTRA
			var background=["url('/progetto/immagini/backgrounds/back1.jpg')",			//VETTORE CONTENENTE URL PER I BACKGROUND
								"url('/progetto/immagini/backgrounds/back2.jpg')",
				                "url('/progetto/immagini/backgrounds/back3.jpg')",
			                    "url('/progetto/immagini/backgrounds/back4.jpg')"];
								
			
			$(document).ready(init());					//QUANDO LA PAGINA E' PRONTA RICHIAMA LA FUNZIONE INIT()
			
			/*FUNZIONE INIZIALIZZAZIONE*/
			function init()
			{
            	buttonAns = 4;
            	timetotal = 20;
            	timeleft = 20;
				correctAns = 0;
				turno = 0;
				playerHealth = 100;
				enemyHealth = 100;
                
				var i = Math.floor(Math.random()*4);
				var bg = background[i];
				$("#body").height(height);
				$("#body").width(width);
				$('#body').css("background-image", bg); 
				$("#quiz").height(height);
				$("#quiz").width(width);
				setTimeout(GameManager,1000);
			}
            
			/*FUNZIONE MANAGER CHE CONTROLLA SALUTE PERSONAGGI E LOOP DI ESECUZIONE*/
			function GameManager()
			{	
				if(playerHealth != 0 && enemyHealth != 0)
					setTimeout(questionDisplay,3000);
			}
            
			/*ESECUZIONE QUERY PER DOMANDE E STAMPA SU SCHERMO*/
			function questionDisplay()
			{
				correctAns = 'Stop' ;$('#question').text('____ in the name of love'); $('#answer3').val('No'); $('#answer2').val('go ahead'); $('#answer1').val('Stop'); $('#answer0').val('Wait');				$("#quiz").addClass('animated slideInLeft');
				$("#quiz").show();
                
				if(turno == 0)
					playerMove();
				if(turno == 1)
					enemyMove();
			}
			
			
			/*TURNO DEL GIOCATORE*/
			function playerMove()
			{
				for(var i = 0; i<4; i++)
					$("#answer"+i).prop('disabled', false);
				timer();	
			}
			
			/*VERIFICA LA CORRETTEZZA E LA PRESSIONE DELLA RISPOSTA*/
			function verify()
			{
               if(buttonAns!=4)
               {
					if($("#answer"+buttonAns).value() == correctAns )
				 	{
						$("#answer"+buttonAns).css("background-color","green");
						punteggio = tempoRisp * 7;
				 	}
				 	else
				 	{
						 $("#answer"+buttonAns).css("background-color","red");
					 	punteggio = 0-(tempoRisp * 7);					
				 	}
				}
                else
                	punteggio = 0-(tempoRisp * 7);	
                    
				setTimeout(function() {
						$("#quiz").addClass('animated slideOutRight');
						$("#quiz").hide();
					},2000);
				timeleft = 20;
			}
			
			
			/*QUANDO VIENE CLICCATA UNA RISPOSTA MEMORIZZA IL NUMERO DEL BOTTONE IN buttonAns 
			  E IL VALORE DI TIMELEFT IN tempoRisp*/
			function selected(x)
			{	
				 tempoRisp = timeleft;
				 buttonAns = x;
			}
			
			
			
			/*FUNZIONE PER TIMER RISPOSTA*/
			function timer() 
			{
				var progressBarWidth = timeleft * $("#timebar").width() / timetotal;
				$("#timebar").find('div')
				.animate({ width: progressBarWidth }, 500)
				.html(Math.floor(timeleft/60));
				if(timeleft > 0) 
                {
					timeleft -=  1;
					setTimeout(timer(), 1000);
				}
				else
				  verify(); 
			}
            
        </script>
         
			
		<style type="text/css">
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

			#body
			{
				background-repeat:no-repeat; 
				background-size:100% 99%;
				margin:0;
			}
			
			
			#player
			{
				position:absolute;
				display:none;
				bottom:0px;
				height:50%;
			}
			
			#quiz
			{ 
				display:none;
				background-color: black;
				margin:0;
				width: 100%;
				height:100%;	
			}
			
			#question
			{
				position:absolute;
				height:25%;
				width:90%;
				left:5%;
				top:10%;
				border-radius:30px;
				background-color: rgba(255,0,0,0.3);
				border-color:rgba(255,0,0,0.8);
				font-size: 44px;
			}
			
			.answers
			{
				position:absolute;
				height:20%;
				width: 30%;
				border-color:rgba(255,0,0,0.8);
				background-color: rgba(255,255,255,1);
				color:black;
				font-size:24px;
			}
			
			.answer :disabled
			{
				background:#dddddd;
			}
			
			#timebar
			{
				width: 90%;
				margin: 10px auto;
				height: 22px;
                background-color: #0A5F44;
			}
			
			#timebar div
			{
				height: 100%;
				text-align: right;
				padding: 0 10px;
				line-height: 22px;
				width: 0;
				background-color: #CBEA00;
				box-sizing: border-box;
			}
		</style>
     
	</head>

	
    <body id="body">
		
		<div id='quiz'>
			<div id = "timebar">
				<div class="bar"> </div>
			</div>
	
			<div id = "question"> </div>
			<input type="button" id="answer0" class="answers" style = "top:40%; left:10%" onclick="selected(0)" > </input>
			<input type="button" id="answer1" class="answers" style = "top:40%; right:10%" onclick="selected(1)" > </input>
			<input type="button" id="answer2" class="answers" style = "top:70%; left:10%" onclick="selected(2)"> </input>
			<input type="button" id="answer3" class="answers" style = "top:70%; right:10%" onclick="selected(3)"> </input>
		</div>

		
	</body>
</html>

