<?php

include 'connessione.php';

session_start();
if (! isset($_SESSION["nickname"])) { // se risulta già un cookie loggato, entra
    header("location: index.php");
    exit();
}
else if ($_SESSION["nickname"]!='root' && $_SESSION["fornitore"] == false){
    header("location: InVendita.php");
    exit();
}


if (isset($_POST["logout"])){
    $_SESSION = [];
    if (isset($_COOKIE[session_name()])){
        setcookie(session_name(),'',time()-50000);
    }
    
    session_destroy();
    
    header("Location: index.php");
    exit;
}

$myNick = $_SESSION["nickname"];
$id_fattura = rand(1000000, 9999999);
$queryCod_fornitore = $mysqli->query("SELECT Cod_Fornitore FROM Fornitore WHERE Nickname = '$myNick'");
$cod_fornitore = $queryCod_fornitore->fetch_row();
$cod_fornitore[0];

if (isset($_POST["aggiungi"])){
    
    //$id_fattura
    //$cod_fornitore[0]
    $data = $_POST['data'];
    $quantita = $_POST['quantita'];
    $totale = $_POST['totale'];
    
    
    //qui ottengo il codice prodotto e la scorta di magazzino, necessaria per aggiornare successivamente il valore del prodotto rifornito
    $prodottoDaFornire = $_POST['prodottoDaFornire'];

    $queryCod_prodotto = $mysqli->query("SELECT Cod_Prodotto, Scorte_magazzino FROM Prodotto WHERE Nome = '$prodottoDaFornire'");
    $prodotto = $queryCod_prodotto->fetch_row();
    //$prodotto[0];//codice prodotto
    //$prodotto[1];//scorte magazzino
        
    if(!$mysqli->query("INSERT INTO Fattura_Dal_Fornitore (ID_Fattura, Cod_Fornitore, Data_Ordine, Totale) VALUES ('$id_fattura', '$cod_fornitore[0]', '$data', '$totale');")){
        die($mysqli->error);
    }
    if(!$mysqli->query("INSERT INTO Fornitura (ID_Fattura, Cod_Fornitore, Cod_Prodotto, Quantita) VALUES ('$id_fattura', '$cod_fornitore[0]', '$prodotto[0]', '$quantita');")){
        die($mysqli->error);
        
    }
    
    $nuovaQuantita = $prodotto[1] + $quantita;//la quantità viene aggiornata di conseguenza
    $queryAggiornaMagazzino = $mysqli->query("UPDATE Prodotto SET Scorte_Magazzino = '$nuovaQuantita' WHERE Prodotto.Cod_Prodotto = '$prodotto[0]'");
    
    
}

?>

<html>
<head></head>
<body>
<form action="fornitore.php" method="POST">
  <center>
  <h1>Benvenuto <?php echo $_SESSION['nickname']?></h1> 
  <h3>qui potrai caricare le tue fatture</h3>
  
	<h4>Fattura:</h4>
	<table>


         <tr><td>Prodotto:</td><td>
		<select name="prodottoDaFornire"> 		
            <?php
            $queryCategorieAggiungi = $mysqli->query("SELECT Nome FROM Prodotto WHERE 1");
            while ($rowAggiungi = $queryCategorieAggiungi->fetch_row()) {
                    echo '<option>'.$rowAggiungi[0].'</option>';               
            }
                
            ?>
            
            </select>	
		<br></td></tr>
         <tr><td>Data ordine:</td><td><input type="date" name="data" value="2018-01-01"></td></tr>   
         <tr><td>Quantità</td><td><input type="text" name="quantita"></td></tr>
         <tr><td>Totale:</td><td><input type="text" name="totale"></td></tr>
	</table>
    	<input type="submit" name="aggiungi" value="aggiungi fattura" />
	
	</center>
	<hr />
	
    <input type="submit" name="logout" value="logout" />
    </form>
    
</body>
</html>