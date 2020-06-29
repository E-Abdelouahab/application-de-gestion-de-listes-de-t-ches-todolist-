<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>todo list</title>
</head>
<body>
<?php
 
require("./config.php");
session_start();
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}



 if (isset($_POST['creer_tache'])) { // On vérifie que la variable POST existe
     if (empty($_POST['creer_tache'])) {  // On vérifie qu'elle as une valeure
         $erreurs = 'Vous devez indiquer la valeure de la tâche';
     } else {
         $tache = $_POST['creer_tache'];
         $db->exec("INSERT INTO todo(todo) VALUES('$tache')"); // On insère la tâche dans la base de donnée
     }
 }
 if (isset($_POST['update_tache'])) { 
        $u_tache = $_POST['update_tache'];
        $id_t = $_POST['id_t'];
        $db->exec("UPDATE todo
        SET todo='$u_tache'
        WHERE id=$id_t");   
}
  
 if(isset($_GET['supprimer_tache'])) {
     $id = $_GET['supprimer_tache'];
     $db->exec("DELETE FROM todo WHERE id=$id");
 }

  
 ?>
  
 
  <a style="color: #000;" href="profile.php"><h1>profile</h1></a>
 <div class="header">
     <p class="header_titre">Ma super Todo List ! </p>
 </div>
  
  
 <form class="taches_input" method="post" action="index.php">
  
  
     <input id="inserer" type="text" name="creer_tache"/>
     <button id="envoyer">Créer</button>
 </form>
 <?php
 if (isset($erreurs)) {
     ?>
     <p><?php echo $erreurs ?></p>
     <?php
 }
 ?>
  
  
 <table class="taches">
     <tr>
         <th>
             N
         </th>
         <th>
             Nom
         </th>
         <th>
             Action
         </th>
     </tr>
     <?php
     $reponse = $db->query('Select * from todo'); // On exécute une requête visant à récupérer les tâches
     while ($taches = $reponse->fetch()) { // On initialise une boucle
         ?>
         <tr>
             <td><?php echo $taches['id'] ?></td>
             <td><?php echo $taches['todo'] ?></td>
             <td><a class="suppr" href="index.php?supprimer_tache=<?php echo $taches['id'] ?>"> delete</a></td>
             <td>   <button type="submit" name="btn_edit" data-toggle="modal" data-target="" class="btn btn-success btn-sm btn-circle btnedit">
                                    update
                                </button></td>
         </tr>
         <?php
     }
     ?>
 </table>

 <!-- Modal -->
 <div id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form  method="post" action="index.php">
  
            <input type="hidden" name="id_t" id="id_t" class="form-control" placeholder="you text">
     <input  type="text" id="u_tache" name="update_tache"/>
     <input type="submit" value="update">
 </form>
            </div>
        </div>
    </div>  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
        $(document).ready(function() {
            $('.btnedit').on('click', function() {
                $('#editmodal').modal('show');
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get(); 
                console.log(data);
                $('#id_t').val(data[0]);
                $('#u_tache').val(data[1]);  
            });
        });
    </script>
</body>
</html>