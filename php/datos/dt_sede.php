<?php
class dt_sede extends resultados_datos_tabla
{
	function get_descripciones($id_nro_ue = null)
	{
            if(isset($id_nro_ue))
                $where = " WHERE id_ue = $id_nro_ue";
            else
                $where = "";
		$sql = "SELECT id_sede, nombre FROM sede $where ORDER BY nombre";
		return toba::db('resultados')->consultar($sql);
	}

        
        function get_descripcion($id_sede){
            $sql = "SELECT nombre FROM sede WHERE id_sede = $id_sede";
            $ar = toba::db('resultados')->consultar($sql);
            return $ar[0]['nombre'];
        }

        function get_unidad($id_sede){
            $sql = "SELECT id_ue FROM sede WHERE id_sede = $id_sede";
            $ar = toba::db('resultados')->consultar($sql);
            return $ar[0]['id_ue'];
        }
}
?>
