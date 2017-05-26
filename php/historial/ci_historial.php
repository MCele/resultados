<?php
class ci_historial extends resultados_ci
{
	protected $s__datos_filtro;
        protected $s__fecha_desde;
        protected $s__fecha_hasta;

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        
	function evt__formulario__filtrar($datos)
	{
            $this->s__fecha_desde = $datos['desde'];
            $this->s__fecha_hasta = $datos['hasta'];
            $this->s__datos_filtro = $datos;
	}
        
        function conf__formulario(toba_ei_formulario $form)
	{
            //no anda el siguiente codigo (quita el boton)       
//          if (isset ($this->s__datos_filtro)) {
//              $form->set_datos($this->s__datos_filtro);
//          }	
	}
        
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	
	function evt__cuadro__btn_ver($seleccion)
	{
            
            toba::memoria()->set_dato("param",  $seleccion['fecha']);
            if (strcasecmp(trim($seleccion['tipo_eleccion']), "Directivo")==0){
                //ir a "Resultados Directivo"
                toba::vinculador()->navegar_a("",10000050,true);
            }
            else{
                //ir a "Resultados Superior"
                toba::vinculador()->navegar_a("", 10000051,true);
            }
	}
        //---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            //se muestran todos los datos en el historial
            $aux = $this->dep('datos')->tabla('mesa')->get_listado_elecciones_periodo(null);
            $cuadro->set_datos($aux);
            //se usan filtros para cargar algunos datos por periodo entre dos fechas
            if(isset($this->s__fecha_desde) && (isset($this->s__fecha_hasta))){
                $aux = $this->dep('datos')->tabla('mesa')->get_listado_elecciones_periodo( 'm.fecha between \''.$this->s__fecha_desde .'\' AND \''.$this->s__fecha_hasta .'\' '); 
                $cuadro->set_datos($aux);
                $this->dep("formulario")->ef("desde")->set_estado($this->s__fecha_desde);
                $this->dep("formulario")->ef("hasta")->set_estado($this->s__fecha_hasta);
            }    
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
	}
        
}
?>