<?php
/**
* Controlador para manejo de Scraping
*
* @author Victor Samayoa - Humberto Herrador
*
*/
	class Ctr_scraping extends CI_Controller {

		/*========== Fin Bloque de comentarios ==========*/
			/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 20/02/2017 10:30:26    	    =
		FUNCIÓN: scrapiar una pagina web
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
	    private $curl_options = array(		// Additional cURL Options
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		);


		public function EventoScraping(){
			$data['curl'] = $this->__curl($_GET['url']);
			
			switch ($_GET['url']) {
				case 'http://whitney.org/Visit/FreeTours':
					if($data['curl'] != ''){
						$this->__FreeTours($data['curl']);
					}else{
						print_r('<pre>');
						var_dump('No se puede scraperar con curl');
						print_r('</pre>');
						die;
					}
				break;
				case 'http://www.meetup.com/ny-tech/':

					$this->__NyTech($data['curl']);
				break;
				case 'http://www.meetup.com/ny-tech':
					$this->__NyTech($data['curl']);
				break;
				case 'http://www.songkick.com/concerts/28130759-michael-bolton-at-st-george-theatre':
					$this->__Songkick($_GET['url']);
				break;
			
				case 'http://filmforum.org/events/event/in-the-mouth-of-the-wolf-with-august-ventura-and-george-malko-event':
					$this->__FillForum($_GET['url']);
				break;
				case 'http://www.newmuseum.org/calendar/view/1141/the-question-of-quantum-feminism':
					$this->__NewUseUm($_GET['url']);
				break;
				case 'https://www.moma.org/calendar/programs/memberearlyhours?locale=es':
					$this->__Moma($_GET['url']);
				break;
				case 'http://www.ifccenter.com/films/brothers-keeper':

				$this->__IfCenter($_GET['url']);
				break;
				case 'https://www.todaytix.com/shows/nyc/3742-free-first-preview':

				$this->__TodayTix($_GET['url']);
				break;
				case 'https://www.moma.org/calendar/events/2811?locale=es':

					$this->__Moma($_GET['url']);
				break;
				case 'http://metmuseum.org/events/programs/met-tours/guided-tours/museum-highlights?eid=251316&program=all&amp;location=main%7cbreuer%7ccloisters&amp;startDate=2%2f22%2f2017+9%3a20%3a59+AM&amp;page=1':
				$this->__MetMuseum($_GET['url']);
				break;
				case 'http://www.songkick.com/concerts/29284039-metallica-at-new-coliseum-presented-by-nycb':
					$this->__Songkick($_GET['url']);
				break;
				case 'http://pianosnyc.com/':
					/*HUMBERTO HERRADOR 05/03/2017*/
					$this->__pianosync($_GET['url']);	
				break;
				default:
					if(strpos($_GET['url'], 'jazz.org') !== false){
						$this->__Jazz($_GET['url']);
					}
					if(strpos($_GET['url'], 'magnettheater.com') !== false){
						$this->__Magnettheater($_GET['url']);
					}
					/*if(strpos($_GET['url'], 'frick.org') !== false){
						$this->__Frick($_GET['url']);
					}*/
					if(strpos($_GET['url'], 'nycballet.com') !== false){
						$this->__Nycballet($_GET['url']);
					}
					/*if(strpos($_GET['url'], 'outputclub.com') !== false){
						$this->__Outputclub($_GET['url']);
					}*/
					if(strpos($_GET['url'], 'thepit-nyc.com') !== false){
						$this->__ThepitNyc($_GET['url']);
					}
					if(strpos($_GET['url'], 'jalopy.biz') !== false){
						$this->__JalopyBiz($_GET['url']);
					}
					if(strpos($_GET['url'], 'beacontheatre.com') !== false){
						$this->__Beacontheatre($_GET['url']);
					}

					if(strpos($_GET['url'], 'carnegiehall.org') !== false){
						$this->__Carnegiehall($_GET['url']);
					}
					if(strpos($_GET['url'], 'angelikafilmcenter.com') !== false){
						$this->__AngelikaFilmCenter($_GET['url']);
					}
					
					$tipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : 1; 
					switch ($tipo) {
						case '1':
							$this->load->library('simple_html_dom');
							$html = str_get_html($_GET['url']);
							//$html = str_get_html($data['curl']);
							print_r('<pre>');
							var_dump($html);
							print_r('</pre>');
							die;
						break;
						case '2':
							print_r('<pre>');
							var_dump($data['curl']);
							print_r('</pre>');
							die;
						break;
						
						default:
							/*print_r('<pre>');
							var_dump($data['curl']);
							print_r('</pre>');*/
							$pokemon_doc = new DOMDocument;
						    libxml_use_internal_errors(true);
						    $pokemon_doc->loadHTML($data['curl']);
						    libxml_clear_errors(); //remove errors for yucky html

						    $pokemon_xpath = new DOMXPath($pokemon_doc);
						    $rupees = $pokemon_xpath->evaluate('string(//div[contains(@class,"twSimpleTableTable")])');
						    //$rupees = $pokemon_xpath->query('//div[contains(@class,"twSimpleTableTable")]');
    						
						    print_r('<pre>');
						    var_dump($rupees);
						    print_r('</pre>');
						    die;
						break;
					}

				break;
			}
	
			$this->load->view('herrador/scraping',$data);

		}
		/*========== Fin Bloque de comentarios ===========*/

		public function ScrapInsertar(){
			$this->load->model('Mdl_scraping');
			$this->Mdl_scraping->_ScrapInsertar2();
		}
		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 20/02/2017 10:16:41       =
		FUNCIÓN: funcion para hace scraping con curl
		PARAMETROS: (string) -> $_gateway_url :: Url del sitio a scrapear 
		POST:
		GET:
		DEVUELVE: (string) -> $response
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __curl($_gateway_url) {
	       
	       $data = array("a" => "a");
	       		//url contra la que atacamos
	       		$ch = curl_init($_gateway_url);
	       		//a true, obtendremos una respuesta de la url, en otro caso, 
	       		//true si es correcto, false si no lo es
	       		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	       		//establecemos el verbo http que queremos utilizar para la petición
	       		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	       		//enviamos el array data
	       		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
	       		//obtenemos la respuesta
	       		$response = curl_exec($ch);
	       		// Se cierra el recurso CURL y se liberan los recursos del sistema
	       		curl_close($ch);
	       		if(!$response) {
	       		    return false;
	       		}else{
	       			return $response;
	       		}
    	}
		/*========== Fin Bloque de comentarios ===========*/

		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 21/02/2017 			    =
		FUNCIÓN: Devuelve array con los datos de la pagina http://whitney.org/Visit/FreeTours
		PARAMETROS: (string) :: $_html :: Contiene todo el html obtenido por medio de curl
		POST:
		GET:
		DEVUELVE: (array) :: $datos == datos de los eventos de la paginas
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __FreeTours($_html){
			$this->load->library('simple_html_dom');
			$html = str_get_html($_html);
			$datos = array();
			foreach ($html->find('div[class=event]') as $key => $evento) {
				$data['titulo'] = $evento->find('div[class=title]')[0]->find('a')[0]->innertext;
				$data['categoria'] = $evento->find('div[class=category]')[0]->innertext;
				$data['hora'] = $evento->find('div[class=times]')[0]->innertext;
				$data['fecha'] = $evento->find('h2')[0]->find('a')[0]->innertext;
				array_push($datos, $data);
			}
	
		}

		/*========== Fin Bloque de comentarios ===========*/


		/*===================================================
		=		       Bloque de comentarios             	=
		=       VICTOR SAMAYOA 		        =
		FUNCIÓN: Devuelve array con los datos de la pagina http://www.ifccenter.com/films/brothers-keeper
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __IfCenter(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[id=page]')) != 0){

			
				if(count($html->find('div[class=ifc-col]')) != 0){
				
				if(count($html->find('h1[class=title]')) != 0){
					
						$title = $html->find('h1')[0]->innertext;
						$fecha = $html->find('p[class=date-time]')[0]->innertext;
						$time = $html->find('ul[class=times]')[0]->innertext;
						$find_content = $html->find('.ifc-col > p');				
						$content = "";
						foreach ($find_content as $key => $value) {
						$content .= '<p>'.$value->innertext.'</p>';
						}
						
					}else{
						$this->__MensajeIfCenter();

					}
				}else{
						$this->__MensajeIfCenter();

					}
			}else{
				$this->__MensajeIfCenter();
			}

			print_r('<pre>');
			var_dump($title);
			var_dump($fecha);
			var_dump($time);
			var_dump($content);
			print_r('</pre>');
			die;
		}


		
		private function __MensajeIfCenter(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}

		/*========== Fin Bloque de comentarios ===========*/


		/*===================================================
		=		       Bloque de comentarios             	=
		=       VICTOR SAMAYOA						        =
		FUNCIÓN: Devuelve array con los datos de la pagina http://35.164.248.122/index.php/Ctr_scraping/EventoScraping?url=https://www.todaytix.com/shows/nyc/3742-free-first-preview
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __TodayTix(){

			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[id=content]')) != 0){

				if(count($html->find('h1[class=_3x30OK4HBZ]')) != 0){
				
					
						$title = $html->find('._3x30OK4HBZ span')[0]->innertext;	
						$content = $html->find('._3H4ue9_ymj')[0]->innertext; 
						$start_date = $html->find('span._13UcQy7pEO span')[0]->innertext;  
						$end_date = $html->find('span._13UcQy7pEO span')[1]->innertext;

				}else{
						$this->__MensajeTodayTix();

					}
			}else{
				$this->__MensajeTodayTix();
			}	

			print_r('<pre>');
			var_dump($title);
			var_dump($content);
			var_dump($start_date);
			var_dump($end_date);
			print_r('</pre>');
			die;
		}
		private function __MensajeTodayTix(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/

		/*========== Fin Bloque de comentarios ===========*/

		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 21/02/2017 10:29:32       =
		FUNCIÓN:  Devuelve array con los datos de la pagina http://www.meetup.com/ny-tech/
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __NyTech($_html){
			$this->load->library('simple_html_dom');
			$html = str_get_html($_html);
		
			//$datos['recentMeetups'] = array();
			//$datos['eventsListModule'] = array();
			$datos = array();
			$recentMeetups = array();
			$eventsListModule = array();
			//$listaModuleLi = $html->find('div[id=events-list-module]')[0]->find('ul[class=event-list]')[0]->find('li[class=event-item]');
			if(count($html->find('div[id=events-list-module]')) != 0){
				$listaModuleLi = $html->find('div[id=events-list-module]')[0];
				if(count($listaModuleLi->find('ul[class=event-list]')) != 0){
					$listaModuleLi = $listaModuleLi->find('ul[class=event-list]')[0]->find('li[class=event-item]');
				}else{
					print_r('<pre>');
					var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 12:24:50 <br> o bien revise la url');
					print_r('</pre>');
					die;
				}
			}else{
				print_r('<pre>');
				var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 12:24:50 <br> o bien revise la url');
				print_r('</pre>');
				die;
			}
			foreach ($listaModuleLi as $key => $eventoLista) {
				$data['titulo'] = $eventoLista->find('a')[0]->innertext;
				$data['fecha'] = $eventoLista->find('li[class=dateTime]')[0]->find('span[class="date"]')[0]->innertext;
				$data['hora'] = $eventoLista->find('li[class=dateTime]')[0]->find('span[class="time"]')[0]->innertext;
				$data['descripcion'] = $eventoLista->find('div[class=event-desc]')[0]->innertext;
				array_push($eventsListModule,$data);
			}

			//$listaModuleLi2 = $html->find('div[id=recentMeetups]')[0]->find('ul[class=event-list]')[0]->find('li[class=event-item]');
			if(count($html->find('div[id=recentMeetups]')) != 0){
				$listaModuleLi2 = $html->find('div[id=recentMeetups]')[0];
				if(count($listaModuleLi2->find('ul[class=event-list]')) != 0){
					$listaModuleLi2 = $listaModuleLi2->find('ul[class=event-list]')[0]->find('li[class=event-item]');
				}else{
					print_r('<pre>');
					var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 12:24:50 <br> o bien revise la url');
					print_r('</pre>');
					die;
				}
			}else{
				print_r('<pre>');
				var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 12:24:50 <br> o bien revise la url');
				print_r('</pre>');
				die;
			}
			
			foreach ($listaModuleLi2 as $key => $eventoLista2) {
				$data2['titulo'] = trim($eventoLista2->find('a[class=event-title]')[0]->innertext);
				$data2['fecha'] = trim($eventoLista2->find('p[class=event-attended]')[0]->innertext);
				//$data2['hora'] = $eventoLista->find('li[class=dateTime]')[0]->find('span[class="time"]')[0]->innertext;
				//$data2['descripcion'] = $eventoLista->find('p')[2]->innertext;
				array_push($recentMeetups,$data2);
			}
			$datos['recentMeetups'] = $recentMeetups;
			$datos['eventsListModule'] = $eventsListModule;
			print_r('<pre>');
			var_dump($datos);
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/

			/*===================================================
		=		       Bloque de comentarios             	=
		=       VICTOR SAMAYOA 		        =
		FUNCIÓN: Devuelve array con los datos de la pagina http://35.164.248.122/index.php/Ctr_scraping/EventoScraping?url=https://www.moma.org/calendar/programs/memberearlyhours?locale=es
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __Moma(){

			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[class=container--full-width]')) != 0){
					if(count($html->find('div[class=calendar]')) != 0){
				
					
						$title = $html->find('h1.page-header__title')[0]->innertext;
						$date = $html->find('h2.page-header__subheading--narrow')[0]->innertext; 

					
					$find_content = $html->find('.happening-description p');
					if(sizeof($find_content) == 0){
					$find_content = $html->find('.program-description');

						
					}				
						$descripcion = "";
						foreach ($find_content as $key => $value) {
						$descripcion .= '<p>'.$value->innertext.'</p>';
						}


				}else{
						$this->__MensajeTodayTix();

					}
			}else{
				$this->__MensajeTodayTix();
			}	

			print_r('<pre>');
			var_dump($title);
			var_dump($date);
			var_dump($descripcion);
			print_r('</pre>');
			die;
		}
		private function __MensajeMoma(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/


/*========== Fin Bloque de comentarios ===========*/

			/*===================================================
		=		       Bloque de comentarios             	=
		=       VICTOR SAMAYOA 		        =
		FUNCIÓN: Devuelve array con los datos de la pagina http://metmuseum.org/events/programs/met-tours/guided-tours/museum-highlights?eid=251316&program=all&amp;location=main%7cbreuer%7ccloisters&amp;startDate=2%2f22%2f2017+9%3a20%3a59+AM&amp;page=1
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __MetMuseum(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[class=container--full-width]')) != 0){
					if(count($html->find('div[class=calendar]')) != 0){
				
					
						$title = $html->find('h1.page-header__title')[0]->innertext;
						$date = $html->find('h2.page-header__subheading--narrow')[0]->innertext; 

					
					$find_content = $html->find('.happening-description p');
					if(sizeof($find_content) == 0){
					$find_content = $html->find('.program-description');

						
					}				
						$descripcion = "";
						foreach ($find_content as $key => $value) {
						$descripcion .= '<p>'.$value->innertext.'</p>';
						}


				}else{
						$this->__MensajeMetMuseum();

					}
			}else{
				$this->__MensajeMetMuseum();
			}	

			print_r('<pre>');
			var_dump($title);
			var_dump($date);
			var_dump($descripcion);
			print_r('</pre>');
			die;
		}
		private function __MensajeMetMuseum(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/


		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 21/02/2017 13:04:32       =
		FUNCIÓN: Devuelve array con los datos de la pagina http://www.songkick.com
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __Songkick(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);
			if(count($html->find('div[class=event-header]')) != 0){
				$fecha = $html->find('div[class=event-header]')[0];
				if(count($fecha->find('div[class=date-and-name]')) != 0){
					$fecha = $fecha->find('div[class=date-and-name]')[0];
					if(count($fecha->find('p')) != 0){
						$fecha = $fecha->find('p')[0]->innertext;
					}else{
						$this->__MensajeSongKick();
					}
				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}

			/*----------------------------------------------------*/
			if(count($html->find('div[class=event-header]')) != 0){
				$artista = $html->find('div[class=event-header]')[0];
				if(count($artista->find('h1[class=summary]')) != 0){
					$artista = $artista->find('h1[class=summary]')[0];
					if(count($artista->find('a[data-analytics-category=event_brief]')) != 0){
						$artista = $artista->find('a[data-analytics-category=event_brief]')[0]->innertext;
					}else{
						$this->__MensajeSongKick();
					}
				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}
			/*----------------------------------------------------*/
			if(count($html->find('div[class=event-header]')) != 0){
				$location = $html->find('div[class=event-header]')[0];
				if(count($location->find('div[class=location]')) != 0){
					$location = $location->find('div[class=location]')[0];
					if(count($location->find('a[data-analytics-category=event_brief]')) != 0){
						$location = $location->find('a[data-analytics-category=event_brief]')[0]->innertext;
					}else{
						$this->__MensajeSongKick();
					}
				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}
			/*------------------------------------------------------------------*/
			if(count($html->find('div[class=event-header]')) != 0){
				$locationSegundaParte = $html->find('div[class=event-header]')[0];
				if(count($locationSegundaParte->find('div[class=location]')) != 0){
					$locationSegundaParte = $locationSegundaParte->find('div[class=location]')[0];
					if(count($locationSegundaParte->find('span')) != 0){
						$locationSegundaParte = $locationSegundaParte->find('span')[1]->innertext;
					}else{
						$this->__MensajeSongKick();
					}
				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}
			print_r('<pre>');
			var_dump($fecha);
			var_dump($artista);
			var_dump($location.','.$locationSegundaParte);
			print_r('</pre>');
			die;
		}

		/*===================================================
		=		       Bloque de comentarios             	=
		=       VICTOR SAMAYOA						       =
		FUNCIÓN: Devuelve array con los datos de la pagina http://35.164.248.122/index.php/Ctr_scraping/EventoScraping?url=http://filmforum.org/events/event/in-the-mouth-of-the-wolf-with-august-ventura-and-george-malko-event
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __FillForum(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);
			if(count($html->find('div[id=content]')) != 0){
				if(count($html->find('div[class=page]')) != 0){
					// obtener titulo
					if(count($html->find('h1.main-title')) != 0){
						$titulo = $html->find('h1.main-title')[0]->innertext;
					}else{
						$this->__MensajeSongKick();
					}
					//obtener hora
					if(count($html->find('div.details')) != 0){
						$hora = $html->find('div.details')[0]->innertext;
					}else{
						$this->__MensajeSongKick();
					}
					//obtener hora
					if(count($html->find('div.copy')) != 0){
						$descripcion = $html->find('div.copy')[0]->innertext;
					}else{
						$this->__MensajeSongKick();
					}


				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}


			print_r('<pre>');
			var_dump($titulo);
			var_dump($hora);
			var_dump($descripcion);
			print_r('</pre>');
			die;
		}
	/*===================================================
		=		       Bloque de comentarios             	=
		=       VICTOR SAMAYOA						       =
		FUNCIÓN: Devuelve array con los datos de la pagina http://www.newmuseum.org/calendar/view/1141/the-question-of-quantum-feminism
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __NewUseUm(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[class=post-view]')) != 0){
				if(count($html->find('h5[class=category-title]')[0]) != 0){
					if(count($html->find('h2')) != 0){
							$fecha = $html->find('h2')[0]->innertext;
					}else{
						$this->__MensajeSongKick();
					}
				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}

			/*----------------------------------------------------*/
			if(count($html->find('div[class=post-view]')) != 0){
				if(count($html->find('div[class=col-threefourths]')[0]) != 0){
						$fecha = $html->find('div[class=col-threefourths]')[0];
					if(count($fecha->find('p')) != 0){
							$parrafo = $html->find('.col-threefourths > p');
							
							$content = "";
							foreach ($parrafo as $value) {
								$content .= "<p>" . $value->innertext ."</p>";
							}

							var_dump($content);die;
					}else{
						$this->__MensajeSongKick();
					}
				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}
			/*----------------------------------------------------*/
		}
		

		
		private function __MensajeSongKick(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}

		/*========== Fin Bloque de comentarios ===========*/


		/*===================================================
		=               Bloque de comentarios            	=
		=       HUMBERTO HERRADOR 04/03/2017       			=
		FUNCIÓN: scraping de la pagina http://pianosnyc.com/
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		=============== MODIFICACIONES ======================
		=====================================================
		===================================================*/
		private function __pianosync($_html){
			$datos['showroom'] = array();
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			if(count($html->find('div[id=thestuff]')[0]) != 0){
				if(count($html->find('div[id=thestuff]')[0]->find('div[id=thecols]')[0]) != 0){
					if(count($html->find('div[id=thestuff]')[0]->find('div[id=thecols]')[0]->find('div[id=longlist]')[0]) != 0){
						if(count($html->find('div[id=thestuff]')[0]->find('div[id=thecols]')[0]->find('div[id=longlist]')[0]->find('div[class=listing]')) !=0){
							$eventos = $html->find('div[id=thestuff]')[0]->find('div[id=thecols]')[0]->find('div[id=longlist]')[0]->find('div[class=listing]');
							foreach ($eventos as $key => $evento) {
								if(count($evento->find('span[class=date]')[0]) != 0){
									$data = array();
									$data['fecha'] = date_parse($evento->find('span[class=date]')[0]->innertext);
									if(count($evento->find('div[class=pricefloater]')[0]) != 0){
										$data['precio'] = $evento->find('div[class=pricefloater]')[0]->innertext;
									}else{
										$this->__MensajePianosync('div[class=pricefloater]');
									}
									
									if(count($evento->find('div[class=bands]')[0]) != 0){ // si las bandas no es vacio
										if(count($evento->find('div[class=bands]')[0]->find('h1')) != 0){
												$bandas = $evento->find('div[class=bands]')[0]->find('h1');
												$bandasHora = $evento->find('div[class=bands]')[0]->find('span[class=time]');
												$data['bandas'] = array();
												foreach ($bandas as $bandaKey => $banda){
													$bandaData = array();
													if(count($banda->find('span[class=caps]')) !=0){
														
														$bandaNombres = $banda->find('span[class=caps]');
														$bandaData['bandaNombre'] = '';
														foreach ($bandaNombres as $bandaKey => $bandaNombre) {
															if($bandaKey == 0){
																$bandaData['bandaNombre'] .= $bandaNombre;
															}else{
																$bandaData['bandaNombre'] .= ' '.$bandaNombre;
															}
														}// end foreach
														/*if($bandasHora[0]->innertext == ''){
															$bandaKeyAux = $bandaKey + 1;
														}else{
															$bandaKeyAux = $bandaKey;
														}
														$bandaData['hora'] = $bandasHora[$bandaKeyAux]->innertext;*/
														$bandaData['size'] = count($bandas);
														
													}else{
														
														//$this->__MensajePianosync('span[class=caps] reales');
														$bandaData['bandaNombre'] = $banda->innertext;
														/*if($bandasHora[0]->innertext == ''){
															$bandaKeyAux = $bandaKey + 1;
														}else{
															$bandaKeyAux = $bandaKey;
														}
														$bandaData['hora'] = $bandasHora[$bandaKeyAux]->innertext;*/
													}
													array_push($data['bandas'], $bandaData);
												}//end foreach
												

										}else{
											$this->__MensajePianosync('div[class=bands] h1');
										}
									}else{
										$this->__MensajePianosync('div[class=bands]');
									}
									array_push($datos['showroom'],$data);
								}else{
									$this->__MensajePianosync('span[class=date]');
								}
							}
							print_r('<pre>');
							var_dump($datos);
							print_r('</pre>');
							die;
								
						}else{
							$this->__MensajeSongKick();
						}	
					}else{
						$this->__MensajeSongKick();
					}
				}else{
					$this->__MensajeSongKick();
				}
			}else{
				$this->__MensajeSongKick();
			}
		}

		private function __MensajePianosync($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ============*/

		/*===================================================
		=               Bloque de comentarios            	=
		=       HUMBERTO HERRADOR 05/03/2017      			=
		FUNCIÓN: scriping de la pagina http://www.jazz.org/
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		=============== MODIFICACIONES ======================
		=====================================================
		===================================================*/
		private function __Jazz($_html){

			$this->load->model('Mdl_scraping');
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$base_url = 'http://www.jazz.org';
			$datos['UpcomingEvents'] = array();
			$datos['urls'] = array();
			if(count($html->find('div[id=mobile_gutter]')[0]) != 0){
				if(count($html->find('div[id=mobile_gutter]')[0]->find('div[class=container-grey]')[0]) != 0){
					if(count($html->find('div[id=mobile_gutter]')[0]->find('div[class=container-grey]')[0]->find('div[class=container]')[0]) != 0){
						if(count($html->find('div[id=mobile_gutter]')[0]->find('div[class=container-grey]')[0]->find('div[class=container]')[0]->find('div[class=row]')) != 0){
							$rows = $html->find('div[id=mobile_gutter]')[0]->find('div[class=container-grey]')[0]->find('div[class=container]')[0]->find('div[class=row]');
							$data = array();
							foreach ($rows as $rowkey => $row) {
								if(count($row->find('div[class=event-listing-details]')) !=0){
									$data['lugar'] = $row->find('div[class=event-listing-details]')[0]->find('p[class="vlocation"]')[0]->innertext;
									if(count($row->find('div[class=event-listing-details]')[0]->find('p[class=vtitle]')[0]) != 0){
										$data['titulo'] = $row->find('div[class=event-listing-details]')[0]->find('p[class=vtitle]')[0]->find('a')[0]->innertext;
										$data['url_relativa'] = $row->find('div[class=event-listing-details]')[0]->find('p[class=vtitle]')[0]->find('a')[0]->attr['href'];
										$data['url'] = $base_url.$data['url_relativa'];
										array_push($datos['urls'], $data['url']);
										$data['datoInterno'] = $this->__JazzInterno($data['url']);
									}else{
										$this->__MensajeJazz('p[class=vtitle] row o evento numero ' . $rowkey);
									}
									//inicio fechas
									if(count($row->find('div[class=event-listing-details]')[0]->find('select[class=event-listing-dropdown]')[0]) != 0){
										if(count($row->find('div[class=event-listing-details]')[0]->find('select[class=event-listing-dropdown]')[0]->find('option')) != 0){
											$fechas = $row->find('div[class=event-listing-details]')[0]->find('select[class=event-listing-dropdown]')[0]->find('option');
											$data['fechas'] = array();
											foreach ($fechas as $fechaKey => $fecha) {
												array_push($data['fechas'],date_parse($fecha->innertext));
											}
										}else{
											$this->__MensajeJazz('select[class=event-listing-dropdown] option row o evento numero ' . $rowkey);
										}
									}else{
										$this->__MensajeJazz('select[class=event-listing-dropdown] row o evento numero ' . $rowkey);
									}
									//fin fechas
									//inicio descripcion
									if(count($row->find('div[class=event-listing-details]')[0]->find('div[class=vtxt]')[0]) != 0){
										if(count($row->find('div[class=event-listing-details]')[0]->find('div[class=vtxt]')[0]->find('p')) != 0){
											$data['descripcion'] = $row->find('div[class=event-listing-details]')[0]->find('div[class=vtxt]')[0]->find('p')[0]->innertext;
										}else{
											$data['descripcion'] = 'No hay descripcion';
											//$this->__MensajeJazz('div[class=vtxt] etique "p" row o evento numero ' . $rowkey);
										}
									}else{
										$this->__MensajeJazz('div[class=vtxt] row o evento numero ' . $rowkey);
									}
									//fin descripcion
									//inicio subtitulo
									if(count($row->find('div[class=event-listing-details]')[0]->find('p[class=event-list-subtitle]')) != 0){
										$data['subTitulo'] = $row->find('div[class=event-listing-details]')[0]->find('p[class=event-list-subtitle]')[0]->innertext;
									}else{
										$this->__MensajeJazz('p[class=event-list-subtitle] row o evento numero ' . $rowkey);
									}
									//fin subtitulo

								}else{
									// no se va colocar mensaje dado que hay varios rows en la estrucura por lo cual no se puede colocar el mensaje
								}
								array_push($datos['UpcomingEvents'], $data);
							}
							//$result = $this->Mdl_scraping->_ScrapInsertar($datos);
							//echo '<h2>Ingreso a base de datos</h2>';
							print_r('<pre>');
							var_dump($datos);
							print_r('</pre>');
							die;
						}else{
							$this->__MensajeJazz('div[class=row]');
						}
					}else{
						$this->__MensajeJazz('div[class=container]');
					}
				}else{
					$this->__MensajeJazz('div[id=mobile_gutter]');
				}
			}else{
				$this->__MensajeJazz('div[class=container-grey]');
			}
		}
		private function __MensajeJazz($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		private function __JazzInterno($_html){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$datos = array();
			if(count($html->find('div[class=col-sm-12 mt10 event_details_body] p')) != 0){
				$datos['descripcion'] = strip_tags($html->find('div[class=col-sm-12 mt10 event_details_body] p')[2]->innertext());
			}else{
				$datos['descripcion'] = '';
			}
			return $datos;
		}

		/*========== Fin Bloque de comentarios ============*/

		/*===================================================
		=               Bloque de comentarios            	=
		=       HUMBERTO HERRADOR 06/03/2017     	  		=
		FUNCIÓN: scrapear la pagina 'http://www.magnettheater.com';
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		=============== MODIFICACIONES ======================
		=====================================================
		===================================================*/
		private function __Magnettheater($_html){
			
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$base_url = 'http://www.magnettheater.com';
			$datos['mainStage'] = array();
			$datos['urls'] = array();
 			if(count($html->find('div[id=tab1]')) != 0){
				if(count($html->find('div[id=tab1]')[0]->find('em[class=date]')) != 0){
					$datos['fecha'] = date_parse($html->find('div[id=tab1]')[0]->find('em[class=date]')[0]->innertext);
				}else{
					$this->__MensajeMagnettheater('em[class=date]');
				}
				if(count($html->find('div[id=tab1]')[0]->find('div[class=post]')) != 0){
					$eventos = $html->find('div[id=tab1]')[0]->find('div[class=post]');
					$data = array();
					foreach ($eventos as $eventoKey => $evento) {
						if(count($evento->find('strong')) != 0){
							if(count($evento->find('strong')[0]->find('a')) != 0){
								$data['titulo'] = $evento->find('strong')[0]->find('a')[0]->innertext;
								if(preg_match('/((http|https|www)[^\s]+)/',$evento->find('strong')[0]->find('a')[0]->attr['href'])){
									$data['url'] = $evento->find('strong')[0]->find('a')[0]->attr['href'];
								}else{
									$data['url'] = $base_url.$evento->find('strong')[0]->find('a')[0]->attr['href'];
								}							
								array_push($datos['urls'], $data['url']);
							}else{
								$this->__MensajeMagnettheater('strong a ===== numero de evento' . $eventoKey);
							}
						}else{
							$this->__MensajeMagnettheater('div[class=post] ===== numero de evento' . $eventoKey);
						}
						if(count($evento->find('em')) != 0){
							if(count($evento->find('em')[0]->find('span')) != 0){
								$data['hora'] = date_parse($evento->find('em')[0]->find('span')[0]->innertext);
								$data['precio'] = strip_tags($evento->find('em')[0]->innertext);
							}else{
								$this->__MensajeMagnettheater('div[id=tab1] post em span ===== numero de evento' . $eventoKey);
							}
						}else{
							$this->__MensajeMagnettheater('div[id=tab1] post em ===== numero de evento' . $eventoKey);
						}

						if(count($evento->find('p')) != 0){
							$data['descripcion'] = strip_tags($evento->find('p')[0]->innertext);
						}
						array_push($datos['mainStage'], $data);
					}
					print_r('<pre>');
					var_dump($datos);
					print_r('</pre>');
					die;
				}else{
					$this->__MensajeMagnettheater('div[class=post]');
				}
			}else{
				$this->__MensajeMagnettheater('div[id=tab1]');
			}
			
		}
		private function __MensajeMagnettheater($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ============*/

		/*===================================================
		=               Bloque de comentarios            	=
		=       HUMBERTO HERRADOR 06/03/2017 			    =
		FUNCIÓN: scraperar la pagina http://www.frick.org/
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		=============== MODIFICACIONES ======================
		=====================================================
		===================================================*/
		private function __Frick($_html){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$datos['conciertos'] = array();
			if(count($html->find('div[class=view-content]')) != 0){
				if(count($html->find('div[class=view-content]')[0]->find('div[class=jcarousel-item]')) != 0){
					$eventos = $html->find('div[class=view-content]')[0]->find('div[class=jcarousel-item]');
					$data = array();
					foreach ($eventos as $eventoKey => $evento) {
						if(count($evento->find('h1[class=field-content]')) != 0){
							$data['titilo'] = strip_tags($evento->find('h1[class=field-content]')[0]->innertext);
						}else{
							$this->__MensajeFrick('h1[class=field-content] numero de evento: '.$eventoKey);
						}
						if(count($evento->find('p')) != 0){
							$data['descripcion'] = strip_tags($evento->find('p')[0]->innertext);
						}else{
							$this->__MensajeFrick('h1[class=field-content] numero de evento: '.$eventoKey);
						}
						array_push($datos['conciertos'], $data);
					}
					print_r('<pre>');
					var_dump($datos);
					print_r('</pre>');
					die;
				}else{
					$this->__MensajeFrick('div[class=view-content] div[class=jcarousel-item]');
				}
			}else{
				$this->__MensajeFrick('div[class=view-content]');
			}
		}

		private function __MensajeFrick($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ============*/

		/*===================================================
		=               Bloque de comentarios            	=
		=       HUMBERTO HERRADOR 06/03/2017      			=
		FUNCIÓN: scrapear https://www.nycballet.com/
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		=============== MODIFICACIONES ======================
		=====================================================
		===================================================*/
		private function __Nycballet($_html){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$datos['eventos'] = array();
			if(count($html->find('div[class=calendarResults]')) != 0){
				if(count($html->find('div[class=calendarResults]')[0]->find('h3')) != 0){
					$datos['fecha'] = preg_replace('/[^0-9]+/', '', $html->find('div[class=calendarResults]')[0]->find('h3')[0]->innertext);
				}else{
					$this->__MensajeFrick('div[class=calendarResults] h3');
				}
				if(count($html->find('div[class=calendarResults]')[0]->find('ul[class=results]')) != 0){
					$eventos = $html->find('div[class=calendarResults]')[0]->find('ul[class=results]');
					$data = array();
					foreach ($eventos as $eventoKey => $evento) {
						if(count($evento->find('header')) != 0){
							$data['fecha'] = date_parse(strip_tags($evento->find('header')[0]->innertext . $datos['fecha'])); 
						}else{
							$this->__MensajeFrick('ul[class=results] header numero de evento : '.$eventoKey);
						}
						if(count($evento->find('div[class=first]')) != 0){
							$data['hora'] = date_parse($evento->find('div[class=first]')[0]->innertext); 
						}else{
							//$this->__MensajeFrick('div[class=first] header numero de evento : '.$eventoKey);
						}
						if(count($evento->find('div[class=second]')) != 0){
							$data['titulo'] = $evento->find('div[class=second]')[0]->innertext; 
						}else{
							//$this->__MensajeFrick('div[class=second] header numero de evento : '.$eventoKey);
						}
						array_push($datos['eventos'], $data);
					}
					print_r('<pre>');
					var_dump($datos);
					print_r('</pre>');
					die;
				}else{
					$this->__MensajeFrick('ul[class=results]');
				}
			}else{
				$this->__MensajeFrick('div[class=calendarResults]');
			}
		}
		private function __MensajeNycballet($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ============*/

		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 06/03/2017       			=
		FUNCIÓN: scrapear http://thepit-nyc.com/
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __ThepitNyc($_html){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$base_url = 'http://thepit-nyc.com';
			$datos['shows'] = array();
			$datos['urls'] = array();
 			if(count($html->find('div[class=row show-for-medium-up]')) != 0){
				if(count($html->find('div[class=row show-for-medium-up]')[0]->find('div[class=columns]')) != 0){
					$columnas = $html->find('div[class=row show-for-medium-up]')[0]->find('div[class=columns]');
					foreach ($columnas as $columnakey => $columna) {
						if(count($columna->find('h5')) != 0){
							$data['nombreColumna'] = $columna->find('h5')[0]->innertext;
						}else{
							$this->__MensajeThepitNyc('div[class=show-for-medium-up] h5');
						}
						if(count($columna->find('a[class=show-title]')) != 0){
							if(count($columna->find('a[class=show-meta-index]')) != 0){
								$eventos = $columna->find('a[class=show-title]');
								$eventosShowIndex = $columna->find('a[class=show-meta-index]');
								$data['eventos'] = array();
								foreach ($eventos as $eventoKey => $evento) {
									$dat['nombre'] = $evento->innertext;
									if(preg_match('/((http|https|www)[^\s]+)/',$evento->attr['href'])){
										$dat['url'] = $evento->attr['href'];
									}else{
										$dat['url'] = $base_url.$evento->attr['href'];
									}							
									array_push($datos['urls'], $dat['url']);
									//$this->__ThepitNycInterno($dat['url']);
									$dat['datoInterno'] = $this->__ThepitNycInterno($dat['url']);
									
									$showIndex = explode('•', strip_tags($eventosShowIndex[$eventoKey]->innertext));
									$dat['hora'] = date_parse($showIndex[0]);
									$dat['precio'] = $showIndex[1];
									array_push($data['eventos'], $dat);
								}
							}else{
								$this->__MensajeThepitNyc('div[class=show-for-medium-up] a[class=show-title]');
							}
						}else{
							$this->__MensajeThepitNyc('div[class=show-for-medium-up] a[class=show-title]');
						}
						array_push($datos['shows'], $data);
					}
					print_r('<pre>');
					var_dump($datos);
					print_r('</pre>');
					die;
				}else{
					$this->__MensajeThepitNyc('div[class=show-for-medium-up] div[class=columns]');
				}

			}else{
				$this->__MensajeThepitNyc('div[class=show-for-medium-up]');
			}

		}

		private function __MensajeThepitNyc($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		private function __ThepitNycInterno($_html){
			//
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$datos = array();
			if(count($html->find('aside[class=small-12 large-5 columns] span')) != 0){
				//$data['fecha'] = $html->find('aside[class=small-12 large-5 columns] span')[0]->innertext;
				//$data['hora'] = strip_tags($html->find('aside[class=small-12 large-5 columns] i[class=fa fa-clock-o]')[0]->parent()->innertext);
				//$data['precio'] = strip_tags($html->find('aside[class=small-12 large-5 columns] i[class=fa fa-usd]')[0]->parent()->innertext);
				//$data['direccion'] = strip_tags($html->find('aside[class=small-12 large-5 columns] i[class=fa fa-map-marker]')[0]->parent()->innertext);
				if(count($html->find('aside[class=small-12 large-5 columns] span')) != 0){
					$data['fecha'] = strip_tags($html->find('aside[class=small-12 large-5 columns] span')[0]->innertext);
				}else{
					$data['fecha'] = '';
				}
				if(count($html->find('aside[class=small-12 large-5 columns] ul li')) != 0){
					$listas = $html->find('aside[class=small-12 large-5 columns] ul li');
					foreach ($listas as $listaKey => $lista) {
						if(count($lista->find('i[class=fa fa-clock-o]')) != 0){
							$data['hora'] = strip_tags($lista->innertext);
						}else{
							if(count($lista->find('i[class=fa fa-usd]')) != 0){
								$data['precio'] = strip_tags($lista->innertext);
							}else{
								if(count($lista->find('i[class=fa fa-map-marker]')) != 0){
									$data['direccion'] = strip_tags($lista->innertext);
								}else{
									if(count($lista->find('i[class=fa fa-map-marker]')) != 0){
										$data['direccion'] = strip_tags($lista->innertext);
									}
								}
							}
						}
					}
				}
				if(count($html->find('div[class=small-12 large-8 columns] p')) != 0){
					$data['descripcion'] = strip_tags($html->find('div[class=small-12 large-8 columns] p')[1]->innertext);
				}else{
					$data['descripcion'] = '';
				}

				array_push($datos, $data);
				return $datos;



			}else{
				$this->__MensajeThepitNyc(¿¿);
			}
		}
		/*========== Fin Bloque de comentarios ===========*/

		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 13/03/2017       			=
		FUNCIÓN: scrapear beacontheatre.com
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __Beacontheatre($_html){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$base_url = 'http://www.beacontheatre.com';
			$datos['shows'] = array();
			$datos['urls'] = array();
			if(count($html->find('div[class=parsys par_artistfeatures]')) != 0){
				if(count($html->find('div[class=parsys par_artistfeatures]')[0]->find('div[class=artistfeature section]')) != 0){
					$artistas = $html->find('div[class=parsys par_artistfeatures]')[0]->find('div[class=artistfeature section]');
					foreach ($artistas as $artistakKey => $artista) {
						if(count($artista->find('h3')) != 0){
							$data['nombre'] = $artista->find('h3')[0]->innertext;
							if(preg_match('/((http|https|www)[^\s]+)/',$artista->find('a')[0]->attr['href'])){
								$data['url'] = $artista->find('a')[0]->attr['href'];
							}else{
								$data['url'] = $base_url.$artista->find('a')[0]->attr['href'];
							}							
							array_push($datos['urls'], $data['url']);
						}else{
							$this->__MensajeBeacontheatre('div[class=artistfeature section] h3');
						}
						
						if(count($artista->find('p')) != 0){
							$data['descripcion'] = strip_tags($artista->find('p')[1]->innertext);
							$data['fecha'] = date_parse(strip_tags($artista->find('p')[1]->innertext));
						}else{
							$this->__MensajeBeacontheatre('div[class=artistfeature section] p');
						}
						array_push($datos['shows'], $data);
					}
					print_r('<pre>');
					var_dump($datos);
					print_r('</pre>');
					die;	
				}else{
					$this->__MensajeBeacontheatre('div[class=parsys par_artistfeatures] div[class=artistfeature section]');
				}

			}else{
				$this->__MensajeBeacontheatre('div[class=parsys par_artistfeatures]');
			}
		}
		/*==FUNCIONES PRIVADAS UTILIZADAS POR LA PRINCIPAL==
		===================================================*/
		private function __MensajeBeacontheatre($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*=================================================
		===================================================*/
		/*========== Fin Bloque de comentarios ===========*/

		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 22/03/2017       			=
		FUNCIÓN: scrapear la pagina https://www.carnegiehall.org/
		PARAMETROS:
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __Carnegiehall($_html){
			$this->load->library('simple_html_dom');
			//$html = file_get_html('http://35.164.248.122/includes/arhivos_scraping/index.html');
			$html = file_get_html($_html);
			$datos = array();
			$datos['fechaCendario'] = '';
			$datos['calendario'] = array();
			/*$etiquetaCalendario = $html->find('div[id=homepage_calendar]',0);
			if($html->find('div[id=homepage_calendar]',0)){
				$etiquetaCalendario = $html->find('div[id=homepage_calendar]');
				if($etiquetaCalendario[0]->find('div[class=tout_headline]',0)){
					$etiquetaToutHeadline = $etiquetaCalendario[0]->find('div[class=tout_headline]'); 
					$datos['fechaCendario'] = trim(strip_tags($etiquetaToutHeadline[0]->innertext));
				}else{
					$this->__MensajeCarnegiehall('div[id=homepage_calendar] div[class=tout_headline]');
				}
			}else{
				$this->__MensajeCarnegiehall('div[id=homepage_calendar]');
			}*/
			if(count($html->find('div[id=homepage_calendar]')) != 0){
				$etiquetaCalendario = $html->find('div[id=homepage_calendar]')[0];
				if(count($etiquetaCalendario->find('h2[class=tout_headline]')) != 0){
					$datos['fechaCendario'] = trim(strip_tags($etiquetaCalendario->find('h2[class=tout_headline]')[0]->innertext));
				}else{
					$this->__MensajeCarnegiehall('div[class=homepage_calendar] div[class=tout_headline]');
				}
			}else{
				$this->__MensajeCarnegiehall('div[id=homepage_calendar]');
			}
			print_r('<pre>');
			var_dump($datos);
			print_r('</pre>');
			die;
		}
		private function __MensajeCarnegiehall($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/

		/*===================================================
		=		       Bloque de comentarios             	=
		=       HUMBERTO HERRADOR 29/03/2017       			=
		FUNCIÓN: scraping a la pagina https://www.angelikafilmcenter.com
		PARAMETROS:
			(string) :: $_html 
		POST:
		GET:
		DEVUELVE:
		NOTA:
		================= MODIFICACIONES ===================
		====================================================
		==================================================*/
		private function __AngelikaFilmCenter($_html){
			$url = fopen($_html,'r');
			if($url){
				$texto = '';
				while(!feof($url)){
					$texto .= fgets($url,512);
				}
				print_r('<pre>');
				var_dump($texto);
				print_r('</pre>');
				die;
			}
			die;
			/*$this->load->library('simple_html_dom');
			$html = file_get_html($_html);
			$datos['eventos'] = array();
			if(count($html->find('div[class=jcarousel jcarousel-events]')) != 0){
				$carrucel = $html->find('div[class=jcarousel jcarousel-events]')[0];
				if(count($carrucel-find('ul li')) != 0){
					$eventos = $carrucel-find('ul li');
					foreach ($eventos as $eventoKey => $evento) {
						$data['mes'] = $evento->find('div[class=event] div[class=date] span[class=month]')[0]->innertext;
						$data['dia'] = $evento->find('div[class=event] div[class=date] span[class=day-number]')[0]->innertext;
						array_push($datos['eventos'], $data);
					}
					print_r('<pre>');
					var_dump($datos);
					print_r('</pre>');
					die;
				}	
			}else{
				$this->__MensajeAngelikaFilmCenter('div[class=jcarousel jcarousel-events]');
			}*/
		}
		/*
			@	HUMBERTO HERRADOR: 29/03/2017
			@	Mostrar el mensaje si algo salio mal en el scrapeo
		*/
		private function __MensajeAngelikaFilmCenter($_mensaje){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta en '.$_mensaje.' que se hizo en el ultimo scraping. Fecha de ultimo scraping: 29/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/
		
	}
?>
