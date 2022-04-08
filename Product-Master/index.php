<?php 

include 'connessione.php';
//require_once 'sessioni.php';//include una volta sola il metodo sessioni
session_start();
if (isset($_SESSION["nickname"])){ //se risulta già un cookie loggato, entra
    header("location: visualizzafatture.php");
    exit;
}

if (isset($_POST["submitx"])){ //se è stato premuto il pulsante submitx, manda la query al db
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    //$query = $mysqli->query("SELECT * FROM Utenti WHERE Nickname = '$nickname' AND Password = '$password'");
    //$query2 = $mysqli->query("SELECT * FROM Fornitore WHERE Nickname = '$nickname' AND Password = '$password'");

    $query = $mysqli->prepare("SELECT * FROM Utenti WHERE Nickname = ? AND Password = ?");
    $query2 = $mysqli->prepare("SELECT * FROM Fornitore WHERE Nickname = ? AND Password = ?");
    
    $query->bind_param('ss',$nickname,$password);
    $query2->bind_param('ss',$nickname,$password);
    
    $query->execute();
    
    //ho deciso di mettere in sicurezza l'accesso al sito utilizzato i prepared statements
    //senza, l'accesso al sito poteva essere messo a rischio semplicemente manomettendo la query
    //ed inserendo ' or ''=' nello username e password.
    
    if($query->fetch()) {//query->num_rows
        echo "Accesso consentito";
        $_SESSION["nickname"] = $nickname;
        $_SESSION["fornitore"] = false;
        header("location: visualizzafatture.php");
        exit();
    } 
    else{
        $query->close();
        $query2->execute();
        echo "Accesso rifiutato";
    }
    
    if($query2->fetch()){//query2->num_rows
        echo "Accesso consentito";
        $_SESSION["nickname"] = $nickname;
        $_SESSION["fornitore"] = true;
        
        header("location: visualizzafatture.php");
        exit();
    }
    
    else {
        echo "Accesso rifiutato";
    }
    
}

$art='
__________                   .___             __       _____                   __
\______   \_______  ____   __| _/_ __   _____/  |_    /     \ _____    _______/  |_  ___________
 |     ___/\_  __ \/  _ \ / __ |  |  \_/ ___\   __\  /  \ /  \\\\__  \  /  ___/\   __\/ __ \_  __ \
 |    |     |  | \(  <_> ) /_/ |  |  /\  \___|  |   /    Y    \/ __ \_\___ \  |  | \  ___/|  | \/
 |____|     |__|   \____/\____ |____/  \___  >__|   \____|__  (____  /____  > |__|  \___  >__|
                              \/           \/               \/     \/     \/            \/
';

?>

<html>
	<body>
			<center><h1>Benvenuto in</h1></center>
			<center>
			<table>
			<tr><td>
			<pre style="font-family: 'Courier New', Courier, monospace"><?php echo $art; ?></pre>
			</tr></td>
		    </table>  
			<h4>Entra in Product Master per trovare con noi le offerte migliori</h4>

		    </center>     
		                                                                                                                                    </p></center>
			<br>
			<form action="index.php" method="POST">
				
				  <center>
    				  <table>
        				  <tr><td>Username:</td><td><input type="text" name="nickname"></td></tr> 
        				  <tr><td></td><td></td></tr>         				  
        				  <tr><td>Password:</td><td><input type="password" name="password"></td></tr> 
    				  </table>
				  </center>
				  
  				  <center><input type="submit" name="submitx" id="submit" value="login"></center>
  				  
			</form>
			
	</body>
</html>