<?php

function angka($number){

    $angka = str_replace(",","",$number);
    $angka = intVal($angka);
    return $angka;
    
}

function angkaFormat($nom)
{
	$rupiah = number_format(intval($nom),0,"0",".");
	$rupiah = $rupiah;
	return $rupiah;
}

function numFormat($nom)
{
	$rupiah = number_format(intval($nom),0,"0",",");
	$rupiah = $rupiah;
	return $rupiah;
}

function rupiah($number){
	$rupiah = number_format(intval($number),0,",",".");
	$rupiah = "Rp.".$rupiah." ";
	return $rupiah;
    
}



?>