<?php
session_start();
if(!isset($_SESSION["username"]))
{
	echo "DEVI EFFETTUARE IL LOGIN";
    header( "refresh:4; url=http://manueldilullotesina.altervista.org/tesina/progetto/login.php");
    die();
}

				$conn = new mysqli("localhost","manueldilullotesina","","my_manueldilullotesina");
				if(!$conn)
				{
					die("ERRORE NEL COMUNICARE CON IL DATABASE");
				}
                $username = $_SESSION['username'];
				$dif = $_GET['dif'];
				$topic = $_GET['topic'];
                
                if($topic == "RANDOM")
				{	
					$query = "SELECT question, correct, wrong1, wrong2, wrong3 FROM domande";
				}
				else
				{
					$query = "SELECT question, correct, wrong1, wrong2, wrong3 FROM domande WHERE category_id='$topic'";
				}
                
               
                $file = simplexml_load_file('domande.xml');
                $xml = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?> <domande/>");
				$stmt = $conn->query($query);
				while($row = $stmt->fetch_array(MYSQLI_ASSOC))
                {
    				$domanda = $xml->addChild('domanda');
 					foreach ($row as $key => $value) 
                    {
    					$domanda->addChild($key, $value);
    				}
                } 
				file_put_contents('domande.xml', $xml->asXML());
?>


<html>
	<head>
		<meta charset="UTF-8">
		<title> HERTZ GAME </title>
        <script src="https://unpkg.com/sweetalert2@7.22.0/dist/sweetalert2.all.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
		
		<script>
        	
            var dif;									//VARIABILE RICEVUTA DAL GET PHP
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
            //VETTORE CONTENENTE URL PER I BACKGROUND
			var background=["url('/tesina/progetto/immagini/backgrounds/back1.jpg')",			
								"url('/tesina/progetto/immagini/backgrounds/back2.jpg')",
				                "url('/tesina/progetto/immagini/backgrounds/back3.jpg')",
			                    "url('/tesina/progetto/immagini/backgrounds/back4.jpg')"];
								
									
			/*FUNZIONE INIZIALIZZAZIONE*/
			function init()
			{
                <?php echo"dif= $dif;";?>
            	tempoRisp = 0;
            	buttonAns = 4;
            	timetotal = 20;
            	timeleft = 20;
				correctAns = 0;
				turno = 0;
				playerHealth = 700;
				enemyHealth = 700;
                
				var i = Math.floor(Math.random()*4);
				var bg = background[i];
				$("#body").height(height);
				$("#body").width(width);
				$('#body').css("background-image", bg); 
				$("#quiz").height(height);
				$("#quiz").width(width);
                swal("LA PARTITA STA INIZIANDO!", "Tieniti pronto!");
				setTimeout(GameManager,1000);
			}
            
			/*FUNZIONE MANAGER CHE CONTROLLA SALUTE PERSONAGGI E LOOP DI ESECUZIONE*/
			function GameManager()
			{	
				if((playerHealth > 0) && (enemyHealth > 0))
				{
                	timeleft = 20;
                	setTimeout(questionDisplay,4000);
                }
                else
                {
                	if(playerHealth <=0)
                    {
                        swal({
                            	type:"error",
                            	title:"HAI PERSO...", 
                                text:"Mi dispiace...sarà per la prossima volta...",
                                footer: "<a href='index.php'> Torna al menù iniziale</a> <br> oppure <br> <p onclick='scorepage(false)'>Aggiorna il tuo score</p>"
                               });
                    }
                    else
                    {	
                                       
                    	swal({	
                            	type:"success",
                            	title:"HAI VINTO!!!", 
                                text: "Complimenti!! Sei fortissimo!!",
                                footer: "<a href='index.php'> Torna al menù iniziale</a> <br> oppure <br> <p onclick='scorepage(true)'>Aggiorna il tuo score</p>"
                             });
                     }
                }
			}
            
			/*ESECUZIONE QUERY PER DOMANDE E STAMPA SU SCHERMO*/
			function questionDisplay()
			{
            
            	var xhttp = new XMLHttpRequest();
  				xhttp.onreadystatechange = function() {
    			if (this.readyState == 4 && this.status == 200) 
                	{
                         	var objXml = this.responseXML;
                         	var num = Math.floor(Math.random()*objXml.getElementsByTagName("question").length);
                			correctAns = objXml.getElementsByTagName("correct")[num].childNodes[0].nodeValue;
                			$('#question').text(objXml.getElementsByTagName("question")[num].childNodes[0].nodeValue);
                			var answers = [ objXml.getElementsByTagName("correct")[num].childNodes[0].nodeValue, 
                							objXml.getElementsByTagName("wrong1")[num].childNodes[0].nodeValue, 
                                			objXml.getElementsByTagName("wrong2")[num].childNodes[0].nodeValue, 
                                			objXml.getElementsByTagName("wrong3")[num].childNodes[0].nodeValue ];
                        	var i = 0;
               				while(i<4)
                			{
                				num = Math.floor(Math.random()*answers.length);
								var ans = answers[num];
								$("#answer"+i).val(ans);
								answers.splice(num,1);
								i++;
                			}
			             
                			timeleft = 20;
							$("#quiz").show();
                
							if(turno == 0)
							{
                				buttonAns = 4;
								punteggio = 0;
                    			for(i = 0; i<4; i++)
				 				$("#answer"+i).prop('disabled', false); 
                    			swal("E' IL TUO TURNO");
                   				playerMove();
							}
                
                			if(turno == 1)
							{	
                				swal("TURNO DEL COMPUTER");
                    			for(i = 0; i<4; i++)
								$("#answer"+i).prop('disabled', true);
                				enemyMove();
                			}
   				 		}
  				};
  				xhttp.open("GET", "domande.xml", true);
  				xhttp.send();
         }
			
			
/*---------------------------------------------------------------------------------------    
-------------QUI SI TROVANO LE FUNZIONI CHE RIGUARDANO IL TURNO DEL GIOCATORE------------
----------------------------------------------------------------------------------------*/

			/*TURNO DEL GIOCATORE*/
			function playerMove()
			{
				if(timeleft>0)
                	k = setInterval(timer,1000);
                else
                {
                  clearInterval(k);
                  verify();
                  if(punteggio>0)
                  {
                    setTimeout(function(){$("#choose").show();},4000);
                  }
                  else
                  {
                  	playerHealth += punteggio;
                    swal("TI SEI DANNEGGIATO CON "+punteggio+" PUNTI", "...", "error")
                    $("#playerHealth")
                    	.val(playerHealth)
                        .html(playerHealth);
                    turno = 1;
                	setTimeout(GameManager,2000);
                  }
                }
			}
            
			
			/*FUNZIONE PER TIMER RISPOSTA*/
			function timer() 
			{
				var progressBarWidth = timeleft * $("#timebar").width() / timetotal;
				$("#timebar").find('div')
				.animate({ width: progressBarWidth }, 500)
				.html(timeleft);
               
				if(timeleft>0) 
                {
					timeleft = timeleft - 1;
				}
                else
                {
                    playerMove();
                }
			}
            
            
            /*QUANDO VIENE CLICCATA UNA RISPOSTA MEMORIZZA IL NUMERO DEL BOTTONE IN buttonAns 
			  E IL VALORE DI TIMELEFT IN tempoRisp*/
			function selected(x)
			{	
				 tempoRisp = timeleft;
				 buttonAns = x;
                 timeleft=0;
			}
            
            
            
            /*VERIFICA LA CORRETTEZZA E LA PRESSIONE DELLA RISPOSTA*/
			function verify()
			{
               if(buttonAns!=4)
               {	
					if($("#answer"+buttonAns).val() == correctAns )
				 	{
						$("#answer"+buttonAns).css("background-color","green");
						punteggio = tempoRisp * 7;
                        swal("HAI INDOVINATO! "+punteggio, "EVVAIII", "success");
				 	}
				 	else
				 	{
						 $("#answer"+buttonAns).css("background-color","red");
					 	punteggio = -(tempoRisp * 7);		
                        swal("HAI SBAGLIATO! "+punteggio, "Mannaggia...", "error");
				 	}
				}
                else
                { 	
                	punteggio = -(15 * 7);
                    swal("NOOO... PERCHE' NON HAI RISPOSTO?", "Eri forse distratto?", "question");
                }   
                
				setTimeout(function() {
                        $("#answer"+buttonAns).css("background-color","rgba(255,255,255,1)");
						$("#quiz").fadeOut("slow");},2000);
                setTimeout(function(){$("#quiz").hide()},6000);
   			}
            
            /*IL GIOCATORE SCEGLIE SE CURARSI O DANNEGGIARE L'AVVERSARIO*/
            function choose(y)
            {
            	if(y=='heal')
                {
                	var test = punteggio + playerHealth;
                    if(test>700)
                    {
                    	playerHealth = 700;
                        $("#playerHealth")
                        	.val(playerHealth)
                            .html(playerHealth);
                        swal("TI SEI CURATO AL MASSIMO!", "Ottimo!", "success");
                    }
                    else
                    {
                		playerHealth += punteggio;
                        $("#playerHealth")
                        	.val(playerHealth)
                            .html(playerHealth);
                        swal("TI SEI CURATO DI "+punteggio+" PUNTI", "Non male!", "success");
                    }
                }
                else
                {
                	enemyHealth -= punteggio;
                    $("#enemyHealth")
                    	.val(enemyHealth)
                        .html(enemyHealth);
                    swal("HAI DANNEGGIATO IL NEMICO CON "+punteggio+" PUNTI", "Complimenti!", "success");
                }
                
                setTimeout(function(){$("#choose").fadeOut("slow");},1000);
                setTimeout(function(){$("#choose").hide()},4000);
                turno = 1;
                setTimeout(GameManager,1000);
            }
            
            
/*---------------------------------------------------------------------------------------    
-------------QUI SI TROVANO LE FUNZIONI CHE RIGUARDANO IL TURNO DEL COMPUTER ------------
----------------------------------------------------------------------------------------*/
		function enemyMove()
        {
        	var cpuRisp = Math.floor(Math.random()*dif);
            if(cpuRisp == 0)
            {	
            	for(var i = 0; i<4; i++)
                {
                	if($("#answer"+i).val() == correctAns )
				 	{
						$("#answer"+i).css("background-color","green");
                        buttonAns = i;
				 		i=4;
                    }
                }
                
                tempoRisp = Math.floor(Math.random()*20);
                punteggio = tempoRisp * 7;
                swal("IL COMPUTER HA INDOVINATO! E TI INFLIGGE "+punteggio+" DANNI", "Stai attento!", "error");
                playerHealth -= punteggio;
                $("#playerHealth")
                	.val(playerHealth)
                	.html(playerHealth);
            }
            else
            {
            	for(var i = 0; i<4; i++)
                {
                	if($("#answer"+i).val() != correctAns )
				 	{
						$("#answer"+i).css("background-color","red");
                        buttonAns = i;
                        i=4;
				 	}
                }
                
                tempoRisp = Math.floor(Math.random()*20);
                punteggio = tempoRisp * 7;
                swal("IL COMPUTER HA SBAGLIATO! E SI AUTO-INFLIGGE "+punteggio+" DANNI", "Sei stato fortunato, eh?", "success");
                enemyHealth -= punteggio;
                $("#enemyHealth")
                	.val(enemyHealth)
                    .html(enemyHealth);
            }
            
            cpuRisp=null;
           	turno = 0;
            setTimeout(GameManager,4000);
            
            setTimeout(function() {
                        $("#answer"+buttonAns).css("background-color","rgba(255,255,255,1)");
						$("#quiz").fadeOut("slow");
                        buttonAns = 4;},4000);
            setTimeout(function(){$("#quiz").hide()},6000);      
        }
        
        function scorepage(flag)
        {
        	var win = window.open("updatescore.php?dif="+dif+"&win="+flag, '_blank');
        }
        </script>
         
			
		<style type="text/css">
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
                background:cover;
				margin:0 0;
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
				background-color: rgba(200,0,0,0.3);
				border-color:rgba(255,0,0,0.8);
				font-size: 44px;
                text-align:center;
                vertical-align:middle;
                color: white;
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
				margin: auto auto;
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
            
            #choose
            {
            	display:none;
            	opacity:1;
                height:100%;
                width:100%;
                background:cover;
            }
            
            #choose button
            {
                height: 30%; 
                width:30%;
                border-color:rgba(255,0,0,0.8);
                background-color: rgba(255,255,255,1); 
                color:black; 
                font-size:36px;
            }
            
            #body progress
            {
            	position:absolute;
            	width:30%;
                height:20px;
                top:7%;
            	background-color:red;	
            }
            
            #body img
            {
            	position:absolute;
                bottom:1%;
                margin:0 0;
                height:70%;
            }
		</style>
     
	</head>

	
    <body id="body" onload="init()">
		
        	<progress id="playerHealth" value="700" max="700" style="left:5%"> </progress>
            <progress id="enemyHealth" value="700" max="700" style="right:5%"> </progress>
            <img style="left:5%;" class="animated bounceInDown" src="/tesina/progetto/immagini/characters/player.png">
        	<img style="right:5%;" class="animated bounceInDown" src="/tesina/progetto/immagini/characters/enemy.png">
        
		<div id='quiz' class="animated slideInLeft">
			<div id = "timebar">
				<div class="bar"> </div>
			</div>
	
			<div id = "question"> </div>
			<input type="button" id="answer0" class="answers" style = "top:40%; left:10%" onclick="selected(0)" > </input>
			<input type="button" id="answer1" class="answers" style = "top:40%; right:10%" onclick="selected(1)" > </input>
			<input type="button" id="answer2" class="answers" style = "top:70%; left:10%" onclick="selected(2)"> </input>
			<input type="button" id="answer3" class="answers" style = "top:70%; right:10%" onclick="selected(3)"> </input>
		</div>
		
        
 		<div id = "choose" class="animated slideInUp">
            <button style="position:absolute; top:35%; left:10%;"  onclick="choose('heal')"> CURATI </button>
            <button style="position:absolute; top:35%; right:10%;" onclick="choose('damage')"> DANNEGGIA </button>
        </div>
		
	</body>
</html>
