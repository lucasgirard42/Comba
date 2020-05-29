<?php



Class Archer extends Personnage

{
    protected $category;
     public function frapper(Personnage $perso)
  {
    if($perso->id() == $this->id)
    {
      return self::CEST_MOI;
    }
    
   $categoryAttaquant = $this-> category();
    $forceAttaquant = $this-> strength();
    
    $this->xp += 25;
    // On indique au personnage qu'il doit recevoir des dégâts.
    // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
    return $perso->recevoirDegats($categoryAttaquant, $forceAttaquant);
  }
  
 
  
   public function recevoirDegats($categoryAttaquant, $forceAttaquant)
  {
      if ($categoryAttaquant == 'magicien') 
      {
        $this->degats += (5 + $forceAttaquant)*2 ;
      }
      else {
        $this->degats += 5 + $forceAttaquant;
      }
    
    
    // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
    if($this->degats >= 100)
    {
      return self::PERSONNAGE_TUE;
    }
    
    // Sinon, on se contente de dire que le personnage a bien été frappé.
    return self::PERSONNAGE_FRAPPE;
  }



    public function category()
    {
      return $this->category;        
    } 


    public function setCategory($category)
  {
    $this->category = $category;
  }

}



