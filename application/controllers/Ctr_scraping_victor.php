<?php
/**
* Controlador para manejo de Scraping
*
* @author Victor Samayoa 
*
*/
	class Ctr_scraping_victor extends CI_Controller {

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
				case 'http://www.joyce.org/performances/sydney-dance-company':
					$this->__Joyce($_GET['url']);
				break;
     			case 'http://www.carolines.com/comedian/vir-das/':
 					$this->__Carolines($_GET['url']);
				break;
			
				case 'http://www.knittingfactory.com/event/7242715':
 					$this->__Knitting($_GET['url']);
				break;
				
				
				case 'http://www.thegarden.com/events/2017/march/eric-clapton.html':
 					$this->__Garden($_GET['url']);
				break;
				
				case 'http://www.slipperroom.com/event/1392733-slipper-room-show-mr-new-york/':
 					$this->__Slipperroom($_GET['url']);
				break;

				case 'http://www.ifccenter.com/films/brothers-keeper':

				$this->__IfCenter($_GET['url']);
				break;

				case 'http://www.bam.org/visualart/2017/arthur-russell-opening-reception':

				if($data['curl'] != ''){
						$this->__Bam($data['curl']);
					}else{
						print_r('<pre>');
						var_dump('No se puede scraperar con curl');
						print_r('</pre>');
						die;
					}

				break;

				case 'http://www.musichallofwilliamsburg.com/event/1314961-radio-dept-brooklyn':

				$this->__Musichallofwilliamsburg($_GET['url']);
				break;

				case 'http://www.thebellhouseny.com/event/1414727-todd-barry-book-release-event-brooklyn/':

				$this->__TheBellHouseNy($_GET['url']);
				break;


				case 'http://gothamcomedyclub.com/event.cfm?id=474065':

				$this->__GothamComedyClub($_GET['url']);
				break;

				case 'http://lpr.com/lpr_events/runnin-on-empty-march-9th-2017/':

				$this->__Lpr($_GET['url']);
				break;

				case 'http://www.brooklynbowl.com/event/1408639-joe-russos-almost-dead-brooklyn/':

				$this->__BrooklynBowl($_GET['url']);
				break;


				case 'https://chelsea.ucbtheatre.com/performance/51450':

				$this->__Chelsea($_GET['url']);
				break;


				case 'http://www.boweryballroom.com/event/1385917-all-them-witches-new-york':

				$this->__Boweryballroom($_GET['url']);
				break;

				case 'http://www.nuyorican.org/event/1213203-friday-night-poetry-slam-5th-new-york/':

				$this->__Nuyorican($_GET['url']);
				break;

				case 'http://lamama.org/judas-iscariot/':

				$this->__Lamama($_GET['url']);
				break;

				/* links verdes*/
				
				case 'http://www.atlasobscura.com/places/evolution-nature-store':

				$this->__AtlasObscura($_GET['url']);
				break;	
					
				case 'http://www.abronsartscenter.org/on-stage/shows/minor-theater-terrifying-world-premiere/':

				$this->__AbronsArtscenter($_GET['url']);
				break;	
					

					


					default:
					# code...
					break;
			}
	
			$this->load->view('herrador/scraping',$data);

		}
		/*========== Fin Bloque de comentarios ===========*/

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
		private function __Joyce(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[class=bodybag]')) != 0){

				if(count($html->find('header[class=page-header]')) != 0){
					
					
						$title = $html->find('h1[class=heading]')[0]->innertext;

						$content = $html->find('div[class=block-copy] p')[0]->innertext; 
			
				}else{
						$this->__MensajeJoy();

					}
			}else{
				$this->__MensajeJoy();
			}	

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
		}
		private function __MensajeJoy(){
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
		private function __Carolines(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[id=body]')) != 0){

				if(count($html->find('div[id=posts]')) != 0){
					
						$title = $html->find('div[class=comedian] h2')[0]->innertext;
						
						$content = $html->find('div[class=entry]')[0]->innertext; 
				
				}else{
						$this->__MensajeCarolines();

					}
			}else{
				$this->__MensajeCarolines();
			}	

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
		}
		private function __MensajeCarolines(){
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
		private function __Knitting(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[class=container]')) != 0){

				if(count($html->find('div[class=main-section-content]')) != 0){
						$title = $html->find('h3[class=event_detail_name]')[0]->innertext;
						$date = $html->find('div[class=event_info_date]')[0]->innertext; 
						$start_time = $html->find('div[class=event_info_show_time]')[0]->innertext; 
						$price = $html->find('div[class=event_info_price]')[0]->innertext; 
						$content = $html->find('div[class=event_detail_description]')[0]->innertext; 
				

				
				}else{
						$this->__MensajeKnitting();

					}
			}else{
				$this->__MensajeKnitting();
			}	

			print_r('<pre>');
			var_dump("Tittle: ". $title);
			var_dump("date: ". $date);
			var_dump("start time: ". $start_time);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
		}
		private function __MensajeKnitting(){
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
		private function __Garden(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[id=leftcolumn]')) != 0){

				if(count($html->find('div[id=event-container]')) != 0){
						$title = $html->find('h1[class=event-title]')[0]->innertext;


						$price = $html->find('div[class=title-price] span')[0]->innertext; 


						$content = $html->find('div[id=event-detail-wrapper]')[0]->innertext; 
				

				
				}else{
						$this->__MensajeGarden();

					}
			}else{
				$this->__MensajeGarden();
			}	

			print_r('<pre>');
			var_dump("Tittle: ". $title);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
		}
		private function __MensajeGarden(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		/*========== Fin Bloque de comentarios ===========*/


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
		private function __Slipperroom(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);


			if(count($html->find('div[class=entry-content]')) != 0){

				if(count($html->find('div[class=event-info]')) != 0){
						$title = $html->find('h1[class=headliners]')[0]->innertext;

						$date = $html->find('h2[class=dates]')[0]->innertext;

						$time = $html->find('h2[class=times]')[0]->innertext;

						$price = $html->find('h3[class=price-range]')[0]->innertext; 


						$content = $html->find('h2[class=description]')[0]->innertext; 
				

				
				}else{
						$this->__MensajeSlipperroom();

					}
			}else{
				$this->__MensajeSlipperroom();
			}	

			print_r('<pre>');
			var_dump("Tittle: ". $title);
			var_dump("Date: ". $date);
			var_dump("Time: ". $time);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
		}
		private function __MensajeSlipperroom(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
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
		private function __Bam($_html){

			$this->load->library('simple_html_dom');
			$html = str_get_html($_html);
		
			$datos = array();
			foreach ($html->find('div[class=contentBlockWrapper]'[0]) as $key => $evento) {
				$data['titulo'] = $evento->find('div[class=moduleHeroDate]')[0]->innertext;
				var_dump($data);die;
				$data['categoria'] = $evento->find('div[class=category]')[0]->innertext;
				$data['hora'] = $evento->find('div[class=times]')[0]->innertext;
				$data['fecha'] = $evento->find('h2')[0]->find('a')[0]->innertext;
				array_push($datos, $data);
			}


			if(count($html->find('div[class=backstage]')) != 0){

			
					var_dump("asd");die;
				if(count($html->find('div[class=multiContainerWrapper]')) != 0){
				
						$title = $html->find('h2')[0]->innertext;
						var_dump($title);die;
						$fecha = $html->find('p[class=date-time]')[0]->innertext;
						$time = $html->find('ul[class=times]')[0]->innertext;
						$find_content = $html->find('.ifc-col > p');				
						$content = "";
						foreach ($find_content as $key => $value) {
						$content .= '<p>'.$value->innertext.'</p>';
						}
						
				
				}else{
						$this->__MensajeBam();

					}
			}else{
				$this->__MensajeBam();
			}

			print_r('<pre>');
			var_dump($title);
			var_dump($fecha);
			var_dump($time);
			var_dump($content);
			print_r('</pre>');
			die;
		}
		private function __MensajeBam(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
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
		private function __Musichallofwilliamsburg(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[class=entry-content]')) != 0){

			
				if(count($html->find('div[class=event-info]')) != 0){
				$title = $html->find('h1[class=headliners summary]')[0]->innertext;
						
						$fecha = $html->find('h2[class=dates]')[0]->innertext;

						$time = $html->find('h2[class=times]')[0]->innertext;

						$price = $html->find('h3[class=price-range]')[0]->innertext;
						

						$content =  $html->find('div[class=bio]')[0]->innertext;

				}else{
						$this->__MensajeMusichallofwilliamsburg();

					}
			}else{
				$this->__MensajeMusichallofwilliamsburg();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $fecha);
			var_dump("Hora: ". $time);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
		}
		private function __MensajeMusichallofwilliamsburg(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
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
		private function __TheBellHouseNy(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[id=content]')) != 0){

			
				if(count($html->find('div[class=entry-content]')) != 0){
			
					
						$title = $html->find('h1[class=headliners summary]')[0]->innertext;
						
						$fecha = $html->find('h2[class=dates]')[0]->innertext;

						$time = $html->find('h2[class=times]')[0]->innertext;

						$price = $html->find('h3[class=price-range]')[0]->innertext;
						

						$content =  $html->find('div[class=bio]')[0]->innertext;
					
				}else{
						$this->__MensajeTheBellHouseNy();

					}
			}else{
				$this->__MensajeTheBellHouseNy();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $fecha);
			var_dump("Hora: ". $time);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;

	
		}
		private function __MensajeTheBellHouseNy(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
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
		private function __GothamComedyClub(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[id=content]')) != 0){

			
				if(count($html->find('div[id=main]')) != 0){
			
					
					$hora = $html->find('li[class=doortime] em')[0]->innertext;
					$description = $html->find('div[class=description]')[0]->innertext;

					$price = $html->find('span[class=minTixPrice]')[0]->innertext;
				
				}else{
						$this->__MensajeGothamComedyClub();

					}
			}else{
				$this->__MensajeGothamComedyClub();
			}

			print_r('<pre>');
			var_dump("hora: ". $hora);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$description);
			print_r('</pre>');
			die;

	
		}
		private function __MensajeGothamComedyClub(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}


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
		private function __Lpr(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[id=container]')) != 0){

			
				if(count($html->find('div[class=single_event]')) != 0){
			
					
					$title = $html->find('span[class=black_visible]')[0]->innertext;
					$date = $html->find('div[class=date_time_info] p');
					$fecha = $date[0]->innertext;
					$hora = $date[1]->innertext;
						
				}else{
						$this->__MensajeLpr();

					}
			}else{
				$this->__MensajeLpr();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $fecha);
			var_dump("Hora: " .$hora);
			print_r('</pre>');
			die;

	
		}
		private function __MensajeLpr(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}
		

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
		private function __BrooklynBowl(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[class=hfeed site]')) != 0){

			
				if(count($html->find('div[class=site-content]')) != 0){
			
					
					$title = $html->find('h1[class=headliners summary]')[0]->innertext;
					$date = $html->find('h2[class=dates] p');
					$price = $html->find('h3[class=price-range]')[0]->innertext;
					$contenido = $html->find('div[class=bio]')[0]->innertext;

					
				}else{
						$this->__MensajeBrooklynBowl();

					}
			}else{
				$this->__MensajeBrooklynBowl();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $date);
			var_dump("Precio: ". $price);
			var_dump("Descripcion: " .$contenido);
			print_r('</pre>');
			die;

	
		}
		private function __MensajeBrooklynBowl(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}

		
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
		private function __Chelsea(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

			if(count($html->find('div[id=contents_container]')) != 0){

			
				if(count($html->find('div[id=content]')) != 0){
			
					
					$title = $html->find('h1[id=performance_title]')[0]->innertext;
					$date = $html->find('h2[class=regular]')[0]->innertext;
			
					$hora = $html->find('h2[class=regular]')[1]->innertext;
					
				}else{
						$this->__MensajeChelsea();

					}
			}else{
				$this->__MensajeChelsea();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $date);
			var_dump("hora: ". $hora);
			print_r('</pre>');
			die;

	
		}
		private function __MensajeChelsea(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}



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
		private function __Boweryballroom(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

		if(count($html->find('div[id=content]')) != 0){

			
				if(count($html->find('div[class=entry-content]')) != 0){
			
					
						$title = $html->find('h1[class=headliners summary]')[0]->innertext;
						
						$fecha = $html->find('h2[class=dates]')[0]->innertext;

						$time = $html->find('h2[class=times]')[0]->innertext;

						$price = $html->find('h3[class=price-range]')[0]->innertext;
						

						$content =  $html->find('div[class=bio]')[0]->innertext;
					
				}else{
						$this->__MensajeTheBellHouseNy();

					}
			}else{
				$this->__MensajeTheBellHouseNy();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $fecha);
			var_dump("Hora: ". $time);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
	
		}
		private function __MensajeBoweryballroom(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}


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
		private function __Nuyorican(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

		if(count($html->find('div[id=content]')) != 0){

			
				if(count($html->find('div[class=entry-content]')) != 0){
			
					
						$title = $html->find('h1[class=headliners summary]')[0]->innertext;
						
						$fecha = $html->find('h2[class=dates]')[0]->innertext;

						$time = $html->find('h2[class=times]')[0]->innertext;

						$price = $html->find('h3[class=price-range]')[0]->innertext;
						

						$content =  $html->find('div[class=bio]')[0]->innertext;
					
				}else{
						$this->__MensajeNuyorican();

					}
			}else{
				$this->__MensajeNuyorican();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $fecha);
			var_dump("Hora: ". $time);
			var_dump("Price: ". $price);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
	
		}
		private function __MensajeNuyorican(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}

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
		private function __Lamama(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

		if(count($html->find('div[class=site-main]')) != 0){

			
				if(count($html->find('div[class=full-container]')) != 0){
			
					
						$title = $html->find('h1[class=entry-title]')[0]->innertext;
						
						$fecha = $html->find('div[class=entry-content] h1')[0]->innertext;


			
						$find_content =  $html->find('div[class=textwidget] h5');
						
							$content = "";
						foreach ($find_content as $key => $value) {
						$content .= '<p>'.$value->innertext.'</p>';
						}

				}else{
						$this->__MensajeLamama();

					}
			}else{
				$this->__MensajeLamama();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $fecha);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
	
		}
		private function __MensajeLamama(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}



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
		private function __AtlasObscura(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

		if(count($html->find('body[class=places]')) != 0){

				if(count($html->find('article[class=place-content]')) != 0){
					
						$title = $html->find('h1[class=item-title]')[0]->innertext;


			
						$find_content =  $html->find('div[id=place-body] ');
						
							$content = "";
						foreach ($find_content as $key => $value) {
						$content .= '<p>'.$value->innertext.'</p>';
						}

				}else{
						$this->__MensajeAtlasObscura();

					}
			}else{
				$this->__MensajeAtlasObscura();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
	
		}
		private function __MensajeAtlasObscura(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}

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
		private function __AbronsArtscenter(){
			$this->load->library('simple_html_dom');
			$html = file_get_html($_GET['url']);

		if(count($html->find('div[class=holder]')) != 0){

				if(count($html->find('div[class=box]')) != 0){
					
						$title = $html->find('div[class=info] h3')[0]->innertext;
						$fecha = $html->find('span[class=data]')[0]->innertext;

			
						$find_content =  $html->find('div[class=txt] ');
						
							$content = "";
						foreach ($find_content as $key => $value) {
						$content .= '<p>'.$value->innertext.'</p>';
						}

				}else{
						$this->__MensajeAbronsArtscenter();

					}
			}else{
				$this->__MensajeAbronsArtscenter();
			}

			print_r('<pre>');
			var_dump("Titulo: ". $title);
			var_dump("Fecha: ". $fecha);
			var_dump("Descripcion: " .$content);
			print_r('</pre>');
			die;
	
		}
		private function __MensajeAbronsArtscenter(){
			print_r('<pre>');
			var_dump('La pagina no contiene la estructura correcta que se hizo en el ultimo scraping. Fecha de ultimo scraping: 21/02/2017 13:24:28 <br> o bien revise la url');
			print_r('</pre>');
			die;
		}


	}
?>
