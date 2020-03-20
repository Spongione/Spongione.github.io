<?php
	session_start();
    $conn = new mysqli("localhost","manueldilullotesina","","my_manueldilullotesina");
	if(!$conn)
	{
		die("ERRORE NEL COMUNICARE CON IL DATABASE");
	}
    
    if(isset($_SESSION['username']))
    {
?>
<html>
	<head>
    	<title> HIGH SCORES</title>
     	
        <style>
        	table
            {
            	text-align: center;
                vertical-align:middle;
                width:100%;
                height:100%;
                border: 2px solid black;
            }
            table th tr td
            {
            	color:black;
            	font-weight:2;
            	font-size:18px;
                width:33%;
                height:10px;
            }
            
            table th
            {
            	background-color:orange;
            }
        </style>
    </head>
    
    <body>
    	<table>
        	<tr>
            	<th>USERNAME</th>
                <th>PUNTEGGIO</th>
             </tr>
    <?php
    	$query = "SELECT username, punteggio
        		  FROM scores INNER JOIN giocatori ON scores.giocatore = giocatori.Username
                  ORDER BY punteggio";
        $table = $conn-> query($query);
        if(!$table)
        {
        	die("Errore nella query $query: " . mysql_error());
        }
        
        $row = $table->fetch_array(MYSQLI_ASSOC);
        while($row!=null)
        {
        	$username = $row["username"];
            $punteggio = $row["punteggio"];
        	echo "<tr> <td> $username </td> <td> $punteggio </td> </tr>"; 
            $row = $table->fetch_array(MYSQLI_ASSOC);
        }
        
        echo"</table> <br> <br> <h2> <b>TUO PUNTEGGIO: </b> </h2>";
        $username = $_SESSION['username'];
        $query = "SELECT punteggio
        		  FROM scores INNER JOIN giocatori ON scores.giocatore = giocatori.Username
                  WHERE giocatori.username = '$username'";
        $table = $conn-> query($query);
        if($table->num_rows!=0)
        {
        	$row = $table->fetch_array(MYSQLI_ASSOC);
            $punteggio = $row['punteggio'];
            echo"$punteggio";
        }
        else
        {
        	echo"Non hai scores registrati";
        }
        
    ?>
        
    </body>
<?php
    }
    else
    {
    	echo "
        		<a href='login.php' 
        		style='position:absolute; top:10%;
                		font-size:28px; font-family:Verdana; text-decoration:none; color:#54aedb'> 
                EFFETTUA L'ACCESSO PER VISUALIZZARE GLI SCORES <br> Clicca qui.</a>";
    }
?>