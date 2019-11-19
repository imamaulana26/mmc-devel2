<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function cetak($str){
	echo htmlentities($str);
}

function input($var){
	$input = htmlentities(strip_tags(trim($var)));
	return $input;
}