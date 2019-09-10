<?php
namespace Calendar;

/* Class qui representera 1 Mois */
class Month {

  public $days=['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
private $months=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
public $month;
public $year;

/**
* Month constructor
* int $month --Le mois compris entre 1 et 12
* int $year L'annee
*/
   public function __construct($month = null,$year = null){/* par défaut =null (?)->nullable)*/

if($month === null){/*= null et pas proche de null*/
  /* la methode date renvois un, ce qui explique l'utilisation des entiers*/

   $month= intval(date('m'));/*renvoi la date actuelle ss format integer(month num)*/
    /*08 --> 8*/
}
if($year=== null){
  $year= intval(date('Y'));/*renvoi la date actuelle ss format integer(Year num)*/
}
if($month <1 ){/*si nous entrons un nombre erroné de mois, cela remontera au dernier mois de l'année précédente*/
  $month = 12;
  $year-= 1;
}
if($month >=1 && $month <12 ){
$month =$month %12;/*Sofiane: ne fonctionne pas avec Decembre 12%12 ==0 */
}else{/* decembre*/
  $month = 12;
}

 $this->month= $month;
  $this->year= $year;
}
/**
*Renvois le premier jour du mois
*
*/
public function getStartingDay(): \DateTime {
/*dateDebut (le 01/ / )*/
 return new \DateTime("{$this->year}-{$this->month}-01");

}
/**
* fonction to String
* retourne le mois en toute lettre (ex: Mois 2019)
*
*/
public function toString(): string {
/*  if($this->month==0){
    $this->month=12;
  $d=$this->months[intval($this->month)] . ' ' . [$this->year -1];

}else{*/
$d=$this->months[$this->month - 1] . ' ' . $this->year;

return  $d;

}
/*
*cette fonction vas retourner le nombre de semaine ds le mois
*
*/

public function getWeeks(): int {

$start=$this->getStartingDay(); /*format date début du mois*/
$end= (clone $start)->modify('+1 month -1 day');/*date de fin du mois-> modification de la copie de $start */
if($this->month==12){  /*tjr 31 jours en decembre*/
$weeks= 6;/* 4 weeks and 2 days*/
}else{
$weeks= intval($end->format('W'))- intval($start->format('W'))+1;/*nbr de semaine ds ce mois*/
}
/* format('W'): Numéro de semaine dans l'année  Exemple : 42 (la 42ème semaine de l'année)*/


if($weeks<0){/*dans le cas de janvier (1er mois de l'annee)*/
    $weeks=intval($end->format('W'));// exemple ($end= la 5ème semaine de l'année et du mois de janvier)
  }


return $weeks;
}

/*
*Est-ce que le jour est ds le mois en cours
*
*/
  public function WithinMonth(\DateTime $date): bool {
/*je compare le mois et l'annee de startingdate avec le mois et annee de ma $date*/
return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
}

/*
*Est-ce que le jour est samedi ou dimanche
*
*/
  public function Inweekend(\DateTime $date): bool {
    /*-'N' 1 pour lundi et 7 pour dimanche */
     return (( $date->format('N')==='6')||($date->format('N')==='7'))? true: false;/*si le jours est samedi ou dimanche*/


}
/*
* Free days :for 2019 2019 2020 
* and national days
*/
  public function Isfreeday(\DateTime $date){
    $day_free=array();
   //////////////// Pour les jours de fêtes://////////////////////////////////////////////
  $path_nd="js/nationalDays.json";
 
   $national_days = file_get_contents($path_nd); 
   $array_decod = json_decode($national_days, true);

  foreach($array_decod as $key => $value ){
    
     if($date->format('m')==$value["date"][0] && $date->format('d')==$value["date"][1]){
       $day_free[]=$value["day"];
     }
  
    }
    /////////////// Pour les jours fériés/////////////////////////////
    $path_fd="js/freeDays.json";
      $data = file_get_contents($path_fd);     
      $array_decod = json_decode($data,true);


     if($date->format('Y')==2019){/*jours fériés pour 2019*/
        foreach ($array_decod["2019"] as $key => $value) {
         if($date->format('m')==$value["month"] && $date->format('d')>=$value["dayStart"] && $date->format('d')<=$value["dayEnd"]){
            // $value["title"]);
            $day_free[]=$value["title"];
            }
          }
        }else if($date->format('Y')==2020){/*jours fériés pour 2020*/
        foreach ($array_decod["2020"] as $key => $value) {
         if($date->format('m')==$value["month"] && $date->format('d')>=$value["dayStart"] && $date->format('d')<=$value["dayEnd"]){
            // $value["title"]);
            $day_free[]=$value["title"];
            }
          }
        }else if($date->format('Y')==2021){/*jours fériés pour 2021*/
        foreach ($array_decod["2021"] as $key => $value) {
         if($date->format('m')==$value["month"] && $date->format('d')>=$value["dayStart"] && $date->format('d')<=$value["dayEnd"]){
            // $value["title"]);
            $day_free[]=$value["title"];
            }
          }
        }
        
     $result=implode(",",$day_free);
/*jours fériés pour 2019*/

/*jours fériés pour 2020*/
return $result;
}
/*
*Est-ce que la date est le jour courant
*
*/
  public function Iscurrentdate($date): bool{
    return ($date->format('Y-m-d')==date('Y-m-d'))? true: false;
  }
/*
* Renvois le mois suivant
*
*/
  public function nextMonth(): Month {
   $month =$this->month + 1;
   $year =$this->year;

   if($month > 12){
     $month = 1;
     $year+= 1 ;
   }
     return new Month($month,$year);
}
/*
* Renvois le mois précédent
*
*/
  public function previousMonth(): Month {
    $month =$this->month - 1;
    $year =$this->year;

    if($month < 1){
      $month = 12;
      $year-= 1;
    }

   return new Month($month,$year);
}
}
