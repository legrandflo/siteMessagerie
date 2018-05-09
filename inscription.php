<!--Afficher un formulaire HTMl 
utiliser base de donnees
aller lire les utilisateurs et message dedans, les ecrire tous
ecrire des donnees dans la base-->

<!DOCTYPE html>
<html>
   <head>
       <title>Creer un chat</title>
       <meta http-equiv="content-type" content="text/html;charset=utf-8" />
       <link rel="stylesheet" type="text/css" href="style.css" />
 
   </head>
   <body>
       
<header>
     <div id="banniere"> 
         <img src='images/logoecriture.jpg'/>
         <h1>Inscription aux Tchats</h1>
     </div>   
</header>

<div id="horloge"></div> 
       
<form action="inscription.php" method="post"> 
    <div id="champutilisateur">
    <fieldset >
        <h2 class="h2inscription"> Identification </h2>
        
        <label for="pseudo">Pseudo :</label> <input type="text" name="pseudo" id="pseudo" size="30" autofocus required/><!--for fait le lien avec id si utilisateur click sur le label ca l'amene dans le champs et autofocus place le curseur dans le champs a ouverture de la page-->
        <label for="mail">Mail :</label>  <input type="email" name="mail"  id="mail" size="50" autocomplete="off" placeholder="mon@adresse.mail" required/>  <!--placeholder ecrit le texte associé puis l'efface quand on ecrit-->
        
    </fieldset>
     </div>   
    <h2 class="h2inscription"> Choix du ou des Chats  </h2>
    <div id="choixchat" >
         <div id="chatlibre" onclick="javasccript:check1()" > <!-- onclick va faire la fonction check1 sur toute la div - voir la fonction-->
             <h3 class="h3chat">Chat libre</h3>
             <p>Ce chat est prévu pour vous permettre de vous exprimer librement.</p>
             <div class="boutonchoix">
                 <input type='checkbox' id="bouton1" name="choix[]" value='1' checked/> <label  for="bouton1">Choisir Chat libre</label>
             </div>
         </div >  
         <div id="chatmusique" onclick="javasccript:check2()">
             <h3 class="h3chat">Chat autour de la musique</h3>
             <p>Passionné de musique : musicien, chanteur,...peuvent échanger sur leur passion commune.</p>
             <div  class="boutonchoix">
                 <input type='checkbox' id="bouton2" name="choix[]" value='2' /> <label  for="bouton2">Choisir Chat musical</label>
             </div>
         </div> 
         <div id="chatsport" onclick="javasccript:check3()" >
             <h3 class="h3chat">Chat à travers le sport</h3>
             <p>Ici place aux sports. Vous pouvez parler des evenements que vous organisés et tous les bons plans.</p>
             <div class="boutonchoix">
                 <input type='checkbox' id="bouton3" name="choix[]" value='3' /> <label  for="bouton3">Choisir Chat sportif</label>
             </div>
        </div>
    </div>
    <div class="bouton">
        <input type="submit" id="soumission" value="s'inscrire" /> 
        <input type="button" id="accueil" name="retouraccueil" value="Page d'accueil" onclick="self.location.href='accueil.php'" onclick>
    </div>
        
    
    
</form>
       
<script>
/* fonction ckeck 1 2 et 3 faite pour qu'on puisse cliquer sur toute la boite d'explication du chat*/
function check1() {
        document.getElementById("bouton1").checked = !document.getElementById("bouton1").checked; //avant le =  on recupere le check de bouton1 et on lui affecte l'inverse, si c'est cliquer ca va decliquer et inverse
    }                                                                                              // fonction realisé sur la boite total du chat car onclick est mis dans la div de la boite 
function check2() {
        document.getElementById("bouton2").checked = !document.getElementById("bouton2").checked;
    }
function check3() {
        document.getElementById("bouton3").checked = !document.getElementById("bouton3").checked;
    }  
 
/*fonction pour creer et faire apparaitre une horloge en temps reel placé en css en haut a gauche*/   
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

<?php
try
    {
    $baseChaton = new PDO('mysql:host=localhost;dbname=chaton;charset=utf8', 'root', '');
    }
catch (Exception $e)
    {
    die('Erreur : ' . $e->getMessage());
    }
  // RAJOUTER LE CAS OU UTILISATEUR EST DEJA INSCRIT A 1 ou 2 CHATS, LUI DIRE ET LUI PROPOSER INSCRIPTION AUX AUTRES      
if (!empty($_POST['pseudo']) && !empty($_POST['mail'])){     //on fait le reste si les champs ont ete rempli
        
        $pseudo = $_POST['pseudo'];
    
        // On recherche si utilisateur est inscrit
        $compteurschat = $baseChaton->query('SELECT COUNT(id_chat) FROM utilisateur,autorisation WHERE utilisateur.id_utilisateur = autorisation.id_utilisateur AND utilisateur.pseudo="'.$pseudo.'"');//on ouvre la table utilisateur et autorisation , on cherche les id chat qui correspond a son pseudo
        $nombrechat = $compteurschat->fetch(); //on lit les donnees du tableau compteurschat et on met se nombre dans tableau nombrechat qui aura qu'une case
        
        if ($nombrechat[0] != 0){  // CAS UTILSATEUR INSCRIT si le nombre chat est different de 0
            switch ($nombrechat[0]) // on indique sur quelle variable on travaille
            { 
                case 1: // dans le cas ou nombre chat inscrit est 1
                    echo "Vous êtes inscrit à 1 chat !!! <br>";
                    echo "Vous pouvez vous inscrire à 2 autres chats <br>";
                break;
                case 2: // dans le cas où nombre chat inscrit est 2
                    echo "Vous êtes inscrit à 2 chats !!! <br>";
                    echo "Vous pouvez vous inscrire à 1 autre chat <br>";
                break;
                case 3: // dans le cas où nombre chat inscrit est 3
                    echo "Vous êtes inscrit aux  3 chats !!! <br>";
                    echo "Vous pouvez retourner à la page d'accueil pour vous connecter";
                break;
                default:
                echo "Désolé, je n'ai pas de message à afficher pour cette note";
            }
            
                        
        }else { // CAS OU UTILSATEUR PAS INSCRIT
                //On enregistre pseudo mail de utilisateur dans table  utilisateur
                $enregistrerutilisateur = $baseChaton -> prepare('INSERT INTO utilisateur(pseudo,mail) VALUES(?, ?)');  
                $enregistrerutilisateur ->execute(array($_POST['pseudo'], $_POST['mail']));
        
    
                // On cherche dans la table utilisateur les champs avec pseudo rentré par utilisateur id utilisateur 
                $utilisateurschat = $baseChaton->query('SELECT * FROM utilisateur WHERE  pseudo="'.$pseudo.'"');//on ouvre la table utilisateur
                $utilisateur = $utilisateurschat->fetch();
                $identif = $utilisateur['id_utilisateur'];
            
                //on recupere dans la table utilisateur id_utilisateur de utilisateur qu'on vient d'ajouter
                echo "Bonjour $pseudo numero utilisateur : $identif <br>";
                $utilisateurschat->closeCursor();
            
                // on recupere les choix de chat de utilisateur et on les met dans la table autorisation
                echo "l'utilisateur $identif est inscrit aux chat : ";
                foreach($_POST['choix'] as $valeur) {
                        $enregistrerchat = $baseChaton -> prepare('INSERT INTO autorisation (id_chat,id_utilisateur) VALUES(?,?)');
                        $enregistrerchat -> execute(array($valeur,$identif));
                        echo $valeur. "  ";
                }
        }    
}

?>

   </body>
     
</html>


 
      