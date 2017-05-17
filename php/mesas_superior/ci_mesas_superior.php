<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ci_mesas_superior extends toba_ci {

    protected $nombre_tabla = 'mesa';
    protected $s__id_claustro;
    protected $s__datos_filtro;
    protected $s__fecha;
    
    //---- Cuadro -----------------------------------------------------------------------

    function conf__filtro(toba_ei_formulario $filtro) {
        if (isset($this->s__datos_filtro))
            $filtro->set_datos($this->s__datos_filtro);
    }
    
    function evt__filtro__filtrar($datos) {
        //ei_arbol($datos);
        $this->s__id_claustro = $datos['id_claustro'];
        $this->s__datos_filtro = $datos;
    }
    
    function conf__cuadro(toba_ei_cuadro $cuadro) {
        if ($this->s__fecha==NULL){
            $this->s__fecha = toba::memoria()->get_dato("param");
        }
        
        if (isset($this->s__id_claustro)){
            $claustro = $this->s__id_claustro;
        }else{
            $claustro=3;
        }

        if ($this->s__fecha != NULL){
                $f= date_create($this->s__fecha);
                $this->pantalla('pant_inicial')->set_titulo($this->pantalla('pant_inicial')->get_titulo()."  ".date_format($f, 'd-m-Y'));
        }
        
        $listas = $this->dep('datos')->tabla('lista_csuperior')->get_listas_actuales($claustro, $this->s__fecha);

        //Agregar las etiquetas de todas las listas
        $columnas=array();
        
        $b['clave'] = 'total';
        $b['titulo'] = 'Total Votos';
        $b['estilo'] = 'col-cuadro-listas';
        $b['estilo_titulo'] = 'tit-cuadro-resultados-mesas';
        $columnas[] = $b;

        foreach ($listas as $lista) {
            $l['clave'] = $lista['id_nro_lista'];
            $l['titulo'] = $lista['nombre'];
            $l['estilo'] = 'col-cuadro-listas';
            $l['estilo_titulo'] = 'tit-cuadro-resultados-mesas';
            $l['total']=true;
            $columnas[] = $l;
        }
        //Agregar datos totales de blancos, nulos y recurridos
        $b['clave'] = 'total_votos_blancos';
        $b['titulo'] = 'Blancos';
        $b['estilo'] = 'col-cuadro-listas';
        //$b['estilo_titulo'] = 'tit-cuadro-resultados-mesas';
        $b['total']=true;
        $columnas[] = $b;

        $b['clave'] = 'total_votos_nulos';
        $b['titulo'] = 'Nulos';
        $b['estilo'] = 'col-cuadro-listas';
        $columnas[] = $b;

        $b['clave'] = 'total_votos_recurridos';
        $b['titulo'] = 'Recurridos';
        $b['estilo'] = 'col-cuadro-listas';
        $columnas[] = $b;
        
        
        //VER!!! Hay que repetir pero ver porqué si no no da el total de votos
        $b['clave'] = 'total';
        $b['titulo'] = 'Total Votos';
        
        $columnas[] = $b;

        $this->dep('cuadro')->agregar_columnas($columnas);
        
        $datos = $this->dep('datos')->tabla($this->nombre_tabla)->get_listado_votos('t_m.id_claustro=' . $claustro, $this->s__fecha);
        return $datos;
    }

}
