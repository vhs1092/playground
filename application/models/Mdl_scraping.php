<?php
	class Mdl_scraping extends CI_Model {


		/*===================================================
		=               Bloque de comentarios            	=
		=       HUMBERTO HERRADOR 22/03/2017      			=
		FUNCIÓN: insertar en base de datos los datos de scrapper
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		=============== MODIFICACIONES ======================
		=====================================================
		===================================================*/
		public function _ScrapInsertar($_args){
			
			/*foreach ($_args['UpcomingEvents'] as $eventokKey => $evento) {
				$titulo = (isset($evento['titulo'])) ? $evento['titulo'] : '';
				$subTitulo = (isset($evento['subTitulo'])) ? $evento['subTitulo'] : '';
				$descripcion = (isset($evento['descripcion'])) ? $evento['descripcion'] : '';
				$lugar = (isset($evento['lugar'])) ? $evento['lugar'] : '';
				$data = array(
					'name' 				=>	$titulo,
					'subTitulo'			=> 	$subTitulo,
					'event_type_id'		=> new MongoId('58a34aadc63998114c00003b'),
					'description'		=> $descripcion,
					'lugar'				=> $lugar,
					'event_source'		=> 'facebook',
					'price'				=> '0',
					'latitude'			=> '0',
					'longitude'			=> '0',
					'recurrent'			=> '0',
					'status'			=> '3',
					'admin_user'		=> new MongoId('58a3fe3b48367b632606ccc6')
				);
				$evento_encontrado = $this->mongo_db->where(array('name' => $titulo))->get('event');
				if(count($evento_encontrado) == 0){
					$resultado = $this->mongo_db->insert('event',$data);
					$event_id = $resultado->{'$id'};
				}else{
					$event_id = $evento_encontrado[0]['_id']->{'$id'};
				}
				

				$year = ($evento['fechas'][0]['year'] != false) ? $evento['fechas'][0]['year'] : '2017';
				$month = ($evento['fechas'][0]['month'] != false) ? $evento['fechas'][0]['month'] : '00';
				$day = ($evento['fechas'][0]['day'] != false) ? $evento['fechas'][0]['day'] : '00';
				$hour = ($evento['fechas'][0]['hour'] != 0) ? $evento['fechas'][0]['hour'] : '00';
				$minute = ($evento['fechas'][0]['minute'] != 0) ? $evento['fechas'][0]['minute'] : '00';
				$second = ($evento['fechas'][0]['second'] != 0) ? $evento['fechas'][0]['second'] : '00';
				$fecha = $year.'/'.$month.'/'.$day;
				$hora = $hour.':'.$minute.':'.$second;
				$datos = array(
					'fecha_inicio'	=>	$fecha,
					'fecha_fin' 	=> 	$fecha,
					'hora_inicio'	=>  $hora,
					'hora_fin'		=> 	'sin hora',
					'event_id'		=> 	new MongoId($event_id));
				$resultado = $this->mongo_db->insert('evento_horario',$datos);
			}*/
			return true;
			//$resultado = $this->mongo_db->where(array('_id' => new MongoId($_args->evento_id)))->set($data)->insert('event');
			//$resultado = $this->mongo_db->set($data)->insert('event');
		}
		/*========== Fin Bloque de comentarios ============*/

		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 23/03/2017       			=
		FUNCIÓN: prueba
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		public function _ScrapInsertar2(){
			$resultado = $this->mongo_db->where(array('name' => 'Prueba Completa','description' => 'Descripcion uno.'))->get('event');
			print_r('<pre>');
			var_dump($resultado[0]['_id']->{'$id'});
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/

	}
?>
