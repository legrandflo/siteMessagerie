<!--Afficher un formulaire HTMl 
utiliser base de donnees
aller lire les utilisateurs et message dedans, les ecrire tous
ecrire des donnees dans la base-->
<?php
session_start();
?>

<!DOCTYPE html>
<html>
   <head>
       <title>Creer un chat</title>
       <meta http-equiv="content-type" content="text/html;charset=utf-8" />
       <link rel="stylesheet" type="text/css" href="style.css" />
       <style type="text/css">
    
     
       </style>
   </head>
   <body>
       
<header>
     <div id="banniere"> 
         <img src='images/logomusique.png'/>
         <h1 class="h1chat2">Chat 2 : Musique</h1>
     </div>   
</header>
<div id="horloge"></div> 
       
 <!--AFFICHER ICI LE PSEUDO DE L'UTILISATEUR GRACE A VARIABLE SESSION QUI RESTE SUR TOUTES LES PAGES-->     
<?php
    $pseudo = $_SESSION['pseudo'];
    echo ("<h1><font color='deepskyblue'>Bonjour $pseudo, bienvenue dans le chat musical...</font></h1>");// font color pour preciser la couleur des caracteres
?>

       
<form action="chat2.php" method="post"> <!--post cache les donnees , apparait pas dans l'adresse-->
    <fieldset class="fieldsetchat">
        <h2 class="h2messChat2"> Message </h2>
        <textarea name="message" rows="5" cols="80" placeholder="Bla-Bla-bla...."></textarea>  
    </fieldset>           
    <input type="submit" id="soumissionchat2" value="Postez votre message " />
    <input type="button" id="accueilchat2" name="retouraccueil" value="Retour page d'accueil" onclick="self.location.href='accueil.php'" style="background-color:white" style="color:white; font-weight:bold"onclick>                                                           
</form>

<!--HORLOGE-->  
<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('horloge').innerHTML = h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
startTime();
</script>

<h2 class="h2messChat2">Liste des messages du Chat :</h2>    
       
<?php
try
    {
    $baseChaton = new PDO('mysql:host=localhost;dbname=chaton;charset=utf8', 'root', '');
    }
catch (Exception $e)
    {
    die('Erreur : ' . $e->getMessage());
    }
       
   
//On ecrit le message dans la base hitorique message
if (!empty($_POST['message'])){  
    $ecrire = $baseChaton -> prepare('INSERT INTO historique_message(heure,message,id_utilisateur,id_chat) VALUES(now(),:texte,:id,2)');  //$_SESSION idUtil vient de la page accueil et conservé pendant tote session
    $ecrire ->execute(array('texte' => $_POST['message'],'id' => $_SESSION['idUtil'],));
    
}
    
//on lit toute la table et on affiche toute les lignes de chat 2
//CHERCHER COMMENT FAIRE JOINTURE POUR aCCEDER A 2 TABLES POUR AVOIR PSEUDO TABLE UTILISATEUR -- FROM LES 2 TABLES AVEC ,
$messages = $baseChaton->query('SELECT * FROM historique_message,utilisateur WHERE historique_message.id_utilisateur = utilisateur.id_utilisateur AND id_chat=2');   
while ($message = $messages->fetch()){                        
     echo $message['heure']." : ".$message['pseudo']." a écrit : ".$message['message']." <br>"; 
    }                                                                                                                                                                               
$messages->closeCursor();  // on ferme la table       

?>      
       

   </body>
    
</html>


