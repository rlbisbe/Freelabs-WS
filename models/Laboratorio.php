<?php 
include('simple_html_dom.php');
include('CURL.php');

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

    public static function get($id,$html = null)
    {
        
        if ($html == null)
			$html = file_get_html("http://www.eps.uam.es/esp/alumnos/lab_horario.php?local_id={$id}&horario_id=17&semestre=S2");

        $id_lab = $html->find('option[selected]');
        $e = $html->find('table');
        $e = $e[0];

        $fichero = $e->outertext;
        $fichero = str_replace("<center>","",$fichero);
        $fichero = str_replace("</center>","",$fichero);

        $e = str_get_html($fichero);
        
        $lab = new Laboratorio();
    
        $lab->lab_id = $id;
        $lab->name = $id_lab[0]->innertext;
        $lab->horas = array();
        
        $t = 0;
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
                if($w % 5 == 0){
                     $lab->horas[$t]["clave"] = $primer;
                     $lab->horas[$t]["valores"][5] = $valor_escapado;

                    //echo "<hr>";
                }
                else
                {
                    $lab->horas[$t]["valores"][$w % 5] = $valor_escapado;
                }
            }
            $t+=1;
        }
        
        return $lab;
    }

    public function getAll(){
        $result = array();
        $html = file_get_html("http://www.eps.uam.es/esp/alumnos/lab_horario.php?horario_id=17&semestre=S2");

        $e = $html->find('select');
        $e = $e[0];
        
        $curl = new CURL();
		$opts = array( CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true  );
        
        foreach($e->find('option') as $g){
                $result[] = array("id" => $g->value, "name" => $g->innertext);
                $id = $g->value;
                $curl->addSession( "http://www.eps.uam.es/esp/alumnos/lab_horario.php?local_id={$id}&horario_id=17&semestre=S2", $opts );
        }
        
        // Ejecuta todas las peticiones en paralelo
        $pages = $curl->exec();
        $curl->clear();
        
        for($i = 0; $i < sizeof($pages) ; $i++) {
			$result[$i]["data"] = Laboratorio::get($result[$i]["id"],$page); 
		}
        
        return $result;
    }
}
