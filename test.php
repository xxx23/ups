<?php

if($env == 'apache2handler' && $env != 'cli')
{
    die('Do not execute on browser!');
}

echo 'end';

?>
