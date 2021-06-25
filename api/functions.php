<?php

function check_plaindrome($string) {
    $string = str_replace(' ', '', $string);
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    $string = strtolower($string);
    $reverse = strrev($string);
    if ($string == $reverse) {
       return 1;
    } 
    else {
        return 0;
    }
}


function count_idlib($idlib){
    $count = 0;
    for($i = 0; $i < strlen($idlib); $i++)
    {
        $count += str_split($idlib)[$i];
    }
    return $count;

}

function fecha_max(){
    $begin = new DateTime();
    $end = clone $begin;
    $end = $end->modify('+14 day'); 
    
    $interval = new DateInterval('P1D');
    $range = new DatePeriod($begin, $interval ,$end);
    
    $cc = 0;
    
    foreach($range as $date) {
    
        if($date->format('N') != 7){
            $cc++;
            if($cc == 5){
                return $date->format('Y-m-d');
            }
        }
            
    
    }
}

function compare_date($date1,$date2){
    $dateTimestamp1 = strtotime($date1);
    $dateTimestamp2 = strtotime($date2);

    if ($dateTimestamp1 > $dateTimestamp2)
       return 1;
    else
        return 0;
}

function getWeekday($date) {
    return date('N', strtotime($date)); 
}
