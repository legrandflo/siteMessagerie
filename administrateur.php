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
<h1>Chat</h1>
<form action="administrateur.php" method="post"> <!--post cache les donnees , apparait pas dans l'adresse-->
   <fieldset> <!--entoure les coordonnees, legend pour le titre dans le cadre-->
        <legend> Coordonnees </legend>
        <label>Pseudo :</label> <input type="text" name="pseudo" id="pseudo" />
        <label>Mail :</label>  <input type="email" name="mail"  autocomplete="off" placeholder="mon@adresse.mail"/>
    </fieldset>
    <fieldset>
        <legend> Message </legend>
        <textarea name="texte" rows="10" cols="80">Bla-bla par défaut...</textarea>  
    </fieldset>           
    <input type="submit" id="soumission" value="Postez votre message " />
    <input type="button" name="retouraccueil" value="Page d'accueil" onclick="self.location.href='accueil.php'" style="background-color:white" style="color:white; font-weight:bold"onclick>
    
        
    
</form>


<h1>Liste des messages du Chat :</h1>    
<?php
        $baseChat = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', ''); //ouvrir la base chat dans $baseChat
       
        //ecrire dans la table (mettre nom table pas $utilisateurs car c'est du PHP pas du SQL.Dans ce cas on connait la variable)
        //$baseChat -> exec('INSERT INTO historique_discussion(nom, email, message) VALUES(\'Jones\', \'Jones@free.fr\', \'Ca va?\')'); 
       
        // Insertion du message à l'aide d'une requête préparée, en utilisant les donnees rentrees par utilisateur, 2 actions parce que £$_POST c'est du PHP et dans prepare c'est du SQL

        $ecrire = $baseChat -> prepare('INSERT INTO historique_discussion(nom, email, message) VALUES(?, ?, ?)');  //INSERT TO langage SQL
        $ecrire ->execute(array($_POST['pseudo'], $_POST['mail'], $_POST['texte']));
       
        //Lire la table dans la base de donnees
        $utilisateurs = $baseChat->query('SELECT * FROM historique_discussion');          // mettre la table historique_discussion dans $utilisateur (* = tous les attributs) SELECT FROM langage SQL
        while ($unUtilisateur = $utilisateurs->fetch()){                      // fetch() pointe sur la premiere ligne de table de $utilisateurs  , la met dans $unUitlisateur, while passe de ligne en ligne
        echo $unUtilisateur['nom']." ".$unUtilisateur['email']."a ecrit :<br />".$unUtilisateur['message'].'<br />'; //$unUtilisateur est une ligne de table sous forme de tableau avec attribut
        }                                                                                                            // echo affiche les valeurs du tableau                                                                

        $utilisateurs->closeCursor();  // on ferme la table  
       
       
       
       
       
?>
   </body>
    
</html>


 <!--AUTRE SOLUTION AVEC UNE FONCTION POUR ECRIRE DANS UNE BASE DE DONNEES
   
    function ecrireChat($bdd) {
        $req = $bdd->prepare('INSERT INTO historique_discussion(nom, email, message) VALUES(:nom, :email, :message)');
        $req->execute(array(
            'nom' => $_POST['pseudo'],
            'email' => $_POST['mail'],
            'message' => $_POST['texte'],
        ));
        echo 'donnée ajoutée';
    }   

    if (!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['texte'])){
        ecrireChat($bdd);
    }


-->

      