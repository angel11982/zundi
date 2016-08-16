<?php
header('Content-Type: text/html; charset=utf-8');

class MYSQL {

	/* variables de conexión */
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;

	/* identificador de conexión y consulta */
	var $Conexion_ID = 0;
	var $Consulta_ID = 0;

	/* número de error y texto error */
	var $Errno = 0;
	var $Error = "";

	/* Método Constructor: Cada vez que creemos una variable de esta clase, se ejecutará esta función */
		function MYSQL($bd = "", $host = _HOST, $user = "nobody", $pass = ""){
			$this->BaseDatos = $bd;
			$this->Servidor = $host;
			$this->Usuario = $user;
			$this->Clave = $pass;
		}
	/* Conexión a la base de datos */
		function conectar($bd, $host, $user, $pass){
			if ($bd != "")
			$this->BaseDatos = $bd;

			if ($host != "")
			$this->Servidor = $host;

			if ($user != "")
			$this->Usuario = $user;

			if ($pass != ""){
			$this->Clave = $pass;
			}

			$this->Conexion_ID = mysqli_connect($this->Servidor, $this->Usuario, $this->Clave) or die('Could not look up user information; ');

			if (!$this->Conexion_ID)
			{
				$this->Error = "Ha fallado la conexion.";
				return 0;
			}

			if (!@mysqli_select_db($this->Conexion_ID,$this->BaseDatos))
			{
				$this->Error = "Imposible abrir ".$this->BaseDatos ;
				return 0;
			}
			mysqli_set_charset($this->Conexion_ID,"utf8");
			/* Si hemos tenido éxito conectando devuelve
			el identificador de la conexión, sino devuelve 0 */
			return $this->Conexion_ID;

		} //fin de conectar

	/* Ejecuta un consulta */
		function consulta($sql = ""){
		if ($sql == ""){
			$this->Error = "No ha especificado una consulta SQL";
			return 0;
		}

		//ejecutamos la consulta
		$this->Consulta_ID = mysqli_query($this->Conexion_ID , $sql ) or die(mysql_error());

		if (!$this->Consulta_ID){
			$this->Errno = mysqli_errno($this->Consulta_ID);
			$this->Error = mysqli_error($this->Consulta_ID);
		}
		/* Si hemos tenido éxito en la consulta devuelve
		el identificador de la conexión, sino devuelve 0 */

		return $this->Consulta_ID;

		} // fin e consulta
	/* Obtener fila */
		function obt_fila(&$rs){
			return 	(@mysqli_fetch_array($rs));
			//return mysql_fetch_row($this->Consulta_ID);
		}
		function obt_fila_id(&$rs){
			return 	(@mysqli_fetch_row($rs));
			//return mysql_fetch_row($this->Consulta_ID);
		}
	/* UltimoID Devuelve el Ultimo id insertado despues de una insercion  */
		function ultimo_id(){
			return (@mysql_insert_id($this->Conexion_ID));
		}
	/* libera el contenido del atributo que almacena las consultas */
		function liberar_consulta($rs){
			mysqli_free_result($rs);
		}
	/* Cierra la Conexion con la BD */
		function desconectar(){
			//if (!$this->Consulta_ID)
			// liberarConsulta();
			mysqli_close($this->Conexion_ID);
		}
	/* Obtione el numero de Error  */
		function obt_NroError(){
			return $this->Errno;
		}
	/* Obtiene el Error */
		function obt_Error(){
			return $this->Error;
		}
	/* Devuelve el número de campos de una consulta */
		function num_campos($rs){
			return mysqli_num_fields($rs);
		}
	/* Devuelve el número de registros de una consulta */
		function num_registros($rs){
			return mysqli_num_rows($rs);
		}
	/* Devuelve el nombre de un campo de una consulta */
		function nombre_campo($rs,$numcampo){
			return mysqli_field_name($rs, $numcampo);
		}
	/* Muestra los datos de una consulta */
		function ver_consulta(){
			echo "<table border=1><tr>";
			// mostramos los nombres de los campos
			for ($i = 0; $i < $this->numcampos(); $i++){
				echo "<td><b>".$this->nombrecampo($i)."</b></td>";
			}
			echo "</tr>";
			// mostrarmos los registros
			while ($row = $this->Obt_Fila()){
				echo "<tr>";
				for ($i = 0; $i < $this->numcampos(); $i++){
					echo "<td>".$row[$i]."</td>";
				}
				echo "</tr>";
			}

		}

		function ejecutar_query(){

		}
}
?>
