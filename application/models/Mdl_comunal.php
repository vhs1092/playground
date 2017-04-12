<?php
	class Mdl_comunal extends CI_Model {
		public function _sanitizeVar( $var, $type = false ){
        	#type = true for array 
            $sanitize = new stdClass(); 
            if ( $type ){ 
                foreach ($var as $key => $value) { 
                    $sanitize->$key = $this->_clearString( $value ); 
                }
                return $sanitize;
            } else { 
                return $this->_clearString( $var ); 
            }
        }  

        public function _sanitizeArray( $var, $type = false ){
            #type = true for array 
            $sanitize = new stdClass(); 
            //if ( $type ){ 
                foreach ($var as $key => $value) { 
                    $sanitize->$key = $this->_clearString( base64_decode($value) ); 
                }
                return $sanitize;
            //} else { 
              //  return $this->_clearString( base64_decode($var) ); 
            //}
        }  

        private function _clearString( $string ){
            $string = strip_tags($string); 
            $string = htmlspecialchars($string); 
            $string = addslashes($string); 
            #$string = quotemeta($string); 
            return $string; 
        } 
        
        /*public function hashPass($string){
            return base64_encode(hash("sha256", base_convert($string, 10, 32))); 
        }*/
        public function hashPass($string) {
	        return str_replace(
	          	'=',
	          	'',
	          	str_shuffle(base64_encode(hash("sha256", base_convert($string, 10, 32))))
	        );
        }

        public function _NotificacionLiveBox($texto){
                $html = '<div class="col-sm-6 col-lg-12">
                            <!-- Info Alert -->
                            <div class="alert alert-info alert-dismissable">
                                <h4><strong>Información</strong></h4>
                                <p>'.$texto.'</p>
                            </div>
                            <!-- END Info Alert -->
                        </div>';
            return $html;
        }
        public function _NotificacionInterLiveBox($datos){
            $html = '';
            foreach ($datos as $key => $value) {
                $html .= '<div>'.$value.'</div>';
            }
            return $html;
        }

       public function _VentanaLiveBox($titulo,$subtitulo,$contenido,$function,$nombreFuncion){
            $html = '       <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">'.$titulo.'</h4>
                                        <p>
                                            '.$subtitulo.'
                                        </p>
                                        <div id="div_mensaje2" style="color:red;"></div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        '.$contenido.'
                                    </div>
                                    <div class="panel-footer" style="display: block;">
                                        <button class="btn btn-default" onclick="FancyCerrar();">Cancelar</button>
                                        <button class="btn btn-primary" onclick="'.$function.';">'.$nombreFuncion.'</button>
                                    </div>
                                </div>
                            </div>';
            return $html;
        }
        
        public function _VentanaContenido($titulo,$contenido){
            $html = '<div class="form-group">
                        <label class="col-sm-4 control-label">'.$titulo.':</label>
                        <div class="col-sm-8">
                            '.$contenido.'
                        </div>
                    </div>';
            return $html;
        }

	}
?>
