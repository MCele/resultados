<?php
class ci_mesas_directivo extends resultados_ci
{
        protected $s__id_claustro;
        protected $s__id_unidad_electoral;
        protected $s__datos_filtro;
        protected $s__fecha;
        
	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            if ($this->s__fecha==NULL){
                $this->s__fecha = toba::memoria()->get_dato("param");
            }
            
            if ($this->s__fecha != NULL){
                $f= date_create($this->s__fecha);
                $this->pantalla('pant_edicion')->set_titulo($this->pantalla('pant_edicion')->get_titulo()."  ".date_format($f, 'd-m-Y'));
            }
            if (isset($this->s__id_claustro)){
                $claustro = $this->s__id_claustro;
            } else {
                $claustro = 1;
            }
            if (isset($this->s__id_unidad_electoral)){
                $unidad_electoral = $this->s__id_unidad_electoral;
            } else {
                $unidad_electoral = 1;
            }

            $listas = $this->dep('datos')->tabla('lista_cdirectivo')->get_listas_actuales($claustro,$unidad_electoral);

            //Agregar las etiquetas de todas las listas
            $columnas = array();
            foreach ($listas as $lista) {
                $l['clave'] = $lista['id_nro_lista'];
                $l['titulo'] = $lista['nombre'];
                $l['total'] = true;
                $columnas[] = $l;
            }
            //Agregar datos totales de blancos, nulos y recurridos
            $b['clave'] = 'total_votos_blancos';
            $b['titulo'] = 'Blancos';
            $b['total'] = true;
            $columnas[] = $b;

            $b['clave'] = 'total_votos_nulos';
            $b['titulo'] = 'Nulos';
            $columnas[] = $b;

            $b['clave'] = 'total_votos_recurridos';
            $b['titulo'] = 'Recurridos';
            $columnas[] = $b;

            $b['clave'] = 'total';
            $b['titulo'] = 'Total Votos';

            $columnas[] = $b;

            $this->dep('cuadro')->agregar_columnas($columnas);
            
            $datos = $this->dep('datos')->tabla('mesa')->get_listado_votos_directivo('t_m.id_claustro=' . $claustro .'AND t_ue.id_nro_ue='.$unidad_electoral, $this->s__fecha);
            
            $cuadro->set_datos($datos);
    }

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $filtro)
	{
		if (isset($this->s__datos_filtro))
                     $filtro->set_datos($this->s__datos_filtro);
	}


	function evt__formulario__btn_filtrar($datos)
	{
		 //ei_arbol($datos);
            $this->s__id_claustro = $datos['claustro'];
            $this->s__id_unidad_electoral = $datos['unidad_electoral'];
            $this->s__datos_filtro = $datos;
	}

}

?>