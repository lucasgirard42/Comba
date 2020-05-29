<?php


function chargerClasse($classname) {
    require './class/'.$classname.'.php';
  }

  spl_autoload_register('chargerClasse');

  session_start(); // On appelle session_start() 

  if (isset($_GET['deconnexion'])) {
    session_destroy();
    header('Location: .');
    exit();
  }