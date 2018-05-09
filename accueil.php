<!--Afficher un formulaire HTMl 
faire inscription (info perso et choix chat)et login des utilisateurs , enregistrer dans 2 bases de donnees
utiliser autre base pour  enregistrer les messages et les lire puis les afficher
garder les infos de utilisateur dans la page chat pour afficher son pseudo
pouvoir cliquer sur une boite entiere (div) pour valider une checkbox-->

<?php
    session_start();
    $_SESSION['idUtil'] = 0;
    $_SESSION['Mail'] = '';
    $_SESSION['Pseudo'] = '';
    
?>
<!DOCTYPE html>
<html>
   <head>
       <title>Accueil_Chaton</title>
       <meta http-equiv="content-type" content="text/html;charset=utf-8" />
       <link rel="stylesheet" type="text/css" href="style.css" />
   </head>
   <body>
 <header>
     <div id="banniere"> 
         <img src='images/logoecriture.jpg'/>
         <h1>Bienvenue dans le site des Tchats</h1>
     </div>   
</header>
<div id="horloge"></div>
<form action="accueil.php" method="post"> 
        
    <div id="login">
        <fieldset>
        <h2 class="h2accueil">LOGIN</h2>
        <label for="mail">Mail : </label>  <input type="email" name="mail" id="mail" size="50" autocomplete="off" placeholder="mon@adresse.mail" autofocus required/><!--autofocus le curseur se place sur le champ a remplir   size agrandi la taille du champ a 50-->
        <input type="submit" id="seconnecter" value=" se connecter " />
        </fieldset>
    </div>
    
    
    <div id="boutonchat">
            <?php
            try
            {
                $baseChaton = new PDO('mysql:host=localhost;dbname=chaton;charset=utf8', 'root', '');
            }
                catch (Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }
        
            if (!empty($_POST['mail'])){        //on fait le reste si les champs ont ete rempli
    
                //On traite le mail de l'utilisateur
                $_SESSION['mail'] = $_POST['mail'];// on stocke adresse mail que utilisateur a rentré dans SESSION
                $utilisateurschat = $baseChaton->query('SELECT id_utilisateur, pseudo FROM utilisateur WHERE mail="'.$_SESSION['mail'].'"');//on ouvre la table utilisateur en prenant id_utilisateur et pseudo si mail= SESSION ATTENTION au GUILLEMET c'est une chaine de caracteres
                $utilisateur = $utilisateurschat->fetch(); 
                $_SESSION['idUtil'] = $utilisateur['id_utilisateur']; //On stocke id utilisateur dans SESSION
                $_SESSION['pseudo'] = $utilisateur['pseudo'];  // On stocke pseudo dans SESSION
                $utilisateurschat->closeCursor();
            
                // Creation bouton si utilisateur est inscrit sinon message retour vers inscription
                $pseudo = $_SESSION['pseudo']; 
                if ($_SESSION['idUtil'] != 0){   
                    echo '<h2><font color="blue">Bonjour '.$pseudo.", cliquez sur les boutons pour accéder aux Chats (bleu:inscrit, jaune:pas encore inscrit)</font> </h2>";
                    $idchat = array();
                    $identifiantschat = $baseChaton->query('SELECT id_chat FROM autorisation WHERE id_utilisateur="'.$_SESSION['idUtil'].'"'); //on     ouvre la table autorisation
                    //on recupere les id_chat correspondant a SESSION['idUtil'] 
                    while ($identifiantchat = $identifiantschat->fetch()){                     
                        $idchat[] = $identifiantchat['id_chat'];
                    }
                    /*  for ($i=0 ; $i<3 ; $i++){  // On lit les numero de chats quon a enregistrer dans tableau idchat
                        echo "chat numero : ".$idchat[$i];  // on les affiche
                        */
                   // recherche des valeurs de id_chat dans tableau pour creer bouton avec lien si elle existe sinon bouton sans lien
                    if (in_array('1', $idchat)){
                        echo ("<a href='Chat1.php' target='_blank'> <input type='button' id='boutonlien' value='Chat aléatoire'> </a>");
                    } else echo ("<input type='button' id='boutonsanslien' value='Chat aléatoire'>");
                    if (in_array('2', $idchat)){
                        echo ("<a href='Chat2.php' target='_blank'> <input type='button' id='boutonlien' value='Chat musical'> </a>");
                    } else echo ("<input type='button' id='boutonsanslien' value='Chat musical'>");
                    if (in_array('3', $idchat)){
                        echo ("<a href='Chat3.php' target='_blank'> <input type='button' id='boutonlien' value='Chat sportif'> </a>");
                    } else echo ("<input type='button' id='boutonsanslien' value='Chat sportif'>");
                    
                    $identifiantschat->closeCursor();                    
                    // si il n'existe pas son $identif est nul , direction vers inscription
                } else echo ("<h2><font color='blue'>Bonjour, vous n'êtes pas inscrit , cliquez sur inscription</font></h2>");
            }
            ?>         
    </div>
        
    <div class="bouton">
        <fieldset>
        <h2 class="h2inscription">INSCRIPTION</h2>
        <input type="button" id="inscription" value="inscription" onclick="self.location.href='inscription.php'" onclick >
        <input type="button" id="administrateur" value="administrateur" onclick="self.location.href='administrateur.php'" onclick>   
        </fieldset>  
    </div> 
 
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


   

   </body>
    
</html>

<?php

 

      