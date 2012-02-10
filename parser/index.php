<?php
    $id = 24;
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    include('simple_html_dom.php');
    include('../models/Laboratorio.php');

    $html = file_get_html("http://www.eps.uam.es/esp/alumnos/lab_horario.php?local_id={$id}&horario_id=17&semestre=S2");

    $e = $html->find('table');
    $e = $e[0];

    $fichero = $e->outertext;
    $fichero = str_replace("<center>","",$fichero);
    $fichero = str_replace("</center>","",$fichero);

    $e = str_get_html($fichero);

    $lab = new Laboratorio();
    
    $lab->lab_id = 24;
    $lab->name = "Laboratorio1";
    $lab->horas = array();
    foreach($e->find('tr') as $f){
        $w = 0;
        foreach($f->find('th') as $g){

            echo '<b>'.$g->innertext . '</b><br>';
            $primer = $g->innertext;
            $w += 1;
            if($w % 6 == 0){
                echo "<hr>";
            }
        }
        $w = 0;
        echo "<hr>";
        foreach($f->find('td') as $g){
            echo $g->innertext . '<br>';
            $w += 1;
            $lab->horas[$primer][$w % 5] = $g->innertext;
            if($w % 5 == 0){
                echo "<hr>";
            }
        }
    }

    print_r($lab->toArray());
?>