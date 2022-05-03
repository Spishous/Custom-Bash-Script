<?php
include 'lib/script_object.class.php';
include_once 'lib/Figlet/Figlet.php';
/*
\\ - Affiche une barre oblique inverse.
\a - Alerte (BEL)
\b - Affiche un caractère de retour arrière.
\c - Supprimer toute sortie supplémentaire
\e - Affiche un caractère d'échappement.
\f - Affiche un caractère de saut de formulaire.
\n - Affiche une nouvelle ligne.
\r - Affiche un retour chariot.
\t - Affiche un onglet horizontal.
\v - Affiche un onglet vertical.
 */

$script = new script_object();
$figlet = new Figlet();
$script->endStyle();
$argv[1]=isset($argv[1]) ? $argv[1] : "";
switch ($argv[1]){
    case '0':
        var_dump($argv);
        $script->printStyle("Test script php ssh",foreground_blue,null,1,0);
        break;
    default:
        $figlet->loadFont(font_slant);
        $script->printText($figlet->getTextCharted("Hello !"))->newline();
        if($argv[1]===""){
            $script->printStyle("Aucun paramètre entré",foreground_green,null,1,0)
                ->newline();
        }else{
            $script->printStyle("Paramètre ".$argv[1]." passé",foreground_green,null,1,0)
            ->newline();
        }
        $a=$script->input('input test: ');
        $script->printText("vous avez entrer ")->printStyle($a,foreground_cyan);
        break;
}
$script->endStyle();
$script->showKey();
echo "\n";
