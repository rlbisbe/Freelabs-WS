<?php 
include('simple_html_dom.php');

class Laboratorio
{
    public $lab_id;
    public $name;
    public $horas;

    public function toArray(){
        return array(
            'lab_id' => $this->lab_id,
            'title' => $this->name,
            'horas' => $this->horas
        );
    }

    public static function ejemplo($id)
    {
        return $id;
    }

    public static function get($id)
    {
        
        $html = file_get_html("http://www.eps.uam.es/esp/alumnos/lab_horario.php?local_id={$id}&horario_id=17&semestre=S2");

        $e = $html->find('table');
        $e = $e[0];

        $fichero = $e->outertext;
        $fichero = str_replace("<center>","",$fichero);
        $fichero = str_replace("</center>","",$fichero);

        $e = str_get_html($fichero);
        
        $lab = new Laboratorio();
    
        $lab->lab_id = $id;
        $lab->name = "Laboratorio1";
        $lab->horas = array();
        
        foreach($e->find('tr') as $f)
        {
            $w = 0;
            foreach($f->find('th') as $g){

                //echo '<b>'.$g->innertext . '</b><br>';
                $primer = $g->innertext;
                $w += 1;
                if($w % 6 == 0){
                    //echo "<hr>";
                }
            }
            $w = 0;
            //echo "<hr>";
            foreach($f->find('td') as $g){
                //echo $g->innertext . '<br>';
                $w += 1;
                $valor_escapado = str_replace("</font></a>","",$g->innertext);
                $valor_escapado = str_replace("<font color=\"black\">","",$valor_escapado);
                $lab->horas[$primer][$w % 5] = $valor_escapado;
                if($w % 5 == 0){
                    //echo "<hr>";
                }
            }
        }
        
        return $lab;
    }
}