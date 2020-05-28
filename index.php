<?php
  
  // On enregistre notre autoload.
  /* function chargerClasse($classname) {
    require $classname.'.php';
  }

  spl_autoload_register('chargerClasse');*/



  
  // On fait appel à la classe Personnage
  require 'class/Personnage.php';
  // On fait appel à la classe PersonnagesManager
  require 'class/PersonnagesManager.php';

  session_start(); // On appelle session_start() 

  if (isset($_GET['deconnexion'])) {
    session_destroy();
    header('Location: .');
    exit();
  }

  

  // On fait appel à la connexion à la bdd
  require 'config/init.php';

  // On fait appel à le code métier
  require 'combat.php';

  
    
    
  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/a58b6117a4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>🥋Vs🥋 Fight ! </title>
    
    <meta charset="utf-8" />
    
  </head>
  <body>
    <p class="text-center">Nombre de personnages créés : <?= $manager->count() ?></p>
<?php
  // On a un message à afficher ?
  if (isset($message)) {
    echo '<b>', $message, '</b>'; // Si oui, on l'affiche.
  }
  // Si on utilise un personnage (nouveau ou pas).
  if (isset($perso)) {
    switch($perso->category()){
      case "magicien":
      $couleur="bg-info";
      break;
      case "guerrier":
      $couleur="bg-danger";
      break;
      case "archer":
      $couleur="bg-success";
      break;
      
  }

?>
    <p class="text-center"><a href="?deconnexion=1">Déconnexion</a></p>

    <div class="card shadow p-3 m-auto <?php echo $couleur ?>" style="width: 18rem;">
          <div class="card-body m-auto" >
            <h5 class="card-title"><?= htmlspecialchars($perso->nom()) ?></h5>
            <fieldset class="card-text">
              <legend>Mes informations</legend>
              <p>
                Nom : <?= htmlspecialchars($perso->nom()) ?><br />
                Dégâts : <?= $perso->degats() ?><br />
                Level : <?= $perso->level() ?><br />
                Force : <?= $perso->strength() ?><br />
                Classe : <?= $perso->category()?>

              </p>
              
            
            </fieldset>
            <a href="#" class="btn btn-primary">Go</a>
          </div>
    </div>

    
    
    

    
    
    
    <fieldset>
      <legend>Qui frapper ?</legend>
      <p>
        <?php
          $persos = $manager->getList($perso->nom());
          if (empty($persos)) {
            echo 'Personne à frapper !';
          } 
          else { ?>

            <?php foreach ($persos as $unPerso)
            { 
              switch($unPerso->category()){
                case "magicien":
                $couleur="bg-info";
                break;
                case "guerrier":
                $couleur="bg-danger";
                break;
                case "archer":
                $couleur="bg-success";
                break;
                
            }?>
            <div class="card mb-5 shadow p-3 <?= $couleur?>" style="width: 18rem;">
              <div class="card-body">
                  <h5 class="card-title"></h5>
                  <p class="card-text">
                  <?php echo htmlspecialchars($unPerso->nom()),
                      '</a> (dégâts : ', $unPerso->degats(),
                      ' level : ',
                      htmlspecialchars($unPerso->level()),
                      ' force : ',
                      htmlspecialchars($unPerso->strength()), ')<br />',
                      'classe : ',
                      htmlspecialchars($unPerso->category());?>
                  </p>
                  <a href="?frapper=<?=$unPerso->id()?>" class="btn btn-primary">frapper</a>
              </div>
            </div>

              
            <?php }
          }
        ?>
      </p>
    </fieldset>
<?php
}
// Sinon on affiche le formulaire de création de personnage
else {
?>
  <form action="" method="post">
    <p>
      Nom : <input type="text" name="nom" maxlength="50" />
      <input type="submit" value="Créer ce personnage" name="creer" />
      <input type="submit" value="Utiliser ce personnage" name="utiliser" />
      <select  name="category">
        <option value="guerrier">guerrier</option>
        <option value="archer">archer</option>
        <option value="magicien">magicien</option>
      </select>
    </p>
  </form>

<?php } ?>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
  if (isset($perso)) {
    $_SESSION['perso'] = $perso;
  }