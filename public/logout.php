<?php
declare(strict_types = 1);                              
include '../src/bootstrap.php';                         

$cms->getSession()->delete();  

redirect('index.php');    

