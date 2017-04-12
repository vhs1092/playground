function getRootURL () {
	return location.hostname;
}

function RootUrlObtener(){
    return location.hostname;
}

function ParametroURL(a){return decodeURIComponent((new RegExp("[?|&]"+a+"=([^&;]+?)(&|#|;|$)").exec(location.search)||[,""])[1].replace(/\+/g,"%20"))||null}  

function FancyAbrir(msg, alto, ancho) {
	jQuery.fancybox('<div class="content_msg">'+msg+'</div>', {
		'height' : alto,
		'width'  : ancho,
		'autoSize' : false
	});
}

function FancyCerrar(){
	$.fancybox.close(true);
}

function CorreoValidar(email) { 
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function CaracterValidar(e,tipo){
	tecla = (document.all) ? e.keyCode : e.which;
    //Tecla de retroceso para borrar, siempre la permite
    switch (tipo){
        case 0:
            if (tecla == 8 || tecla == 32 || tecla == 0) return true;
            // Patron de entrada para letras
            patron =/[A-Za-z]/; 
            break;
        case 1:
            if (tecla == 8 || tecla == 0) return true;
            // Patron de entrada para numeros
            patron = /\d/;  
            break;
        case 2:
            if (tecla == 8 || tecla == 0 || tecla == 46) return true;
            // Patron de entrada para numeros
            patron = /\d/;
            break; 
        case 3:
            //Reconoce números con un único punto decimal
            if (tecla == 8 || tecla == 0 || tecla == 46){
                if (tecla == 46 && punto == 0){
                    punto = 1;
                    return true;
                }
                if(tecla == 8 || tecla == 0){
                    return true;
                }
            }
            // Patron de entrada para numeros
            patron = /\d/;  
            break;
        case 4:
            if (tecla == 8 || tecla == 0) return true;
            // Patron de entrada para letras sin espacio
            patron =/[A-Za-z]/; 
            break;
        default:
            if (tecla == 8 || tecla == 32 || tecla == 0) return true;
            // Patron de entrada para letras
            patron =/[A-Za-z]/; 
            break;
    }
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function utf8_encode (string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";
 
    for (var n = 0; n < string.length; n++) {
 
      var c = string.charCodeAt(n);
 
      if (c < 128) {
        utftext += String.fromCharCode(c);
      }
      else if((c > 127) && (c < 2048)) {
        utftext += String.fromCharCode((c >> 6) | 192);
        utftext += String.fromCharCode((c & 63) | 128);
      }
      else {
        utftext += String.fromCharCode((c >> 12) | 224);
        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
        utftext += String.fromCharCode((c & 63) | 128);
      }
 
    }
 
    return utftext;
}

function Codificar(input) {
    var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;
 
    input = utf8_encode(input);
 
    while (i < input.length) {
 
      chr1 = input.charCodeAt(i++);
      chr2 = input.charCodeAt(i++);
      chr3 = input.charCodeAt(i++);
 
      enc1 = chr1 >> 2;
      enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
      enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
      enc4 = chr3 & 63;
 
      if (isNaN(chr2)) {
        enc3 = enc4 = 64;
      } else if (isNaN(chr3)) {
        enc4 = 64;
      }
 
      output = output +
      _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
      _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
 
    }
 
    return output;
}

function encode(input) {
    var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;
 
    input = utf8_encode(input);
 
    while (i < input.length) {
 
      chr1 = input.charCodeAt(i++);
      chr2 = input.charCodeAt(i++);
      chr3 = input.charCodeAt(i++);
 
      enc1 = chr1 >> 2;
      enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
      enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
      enc4 = chr3 & 63;
 
      if (isNaN(chr2)) {
        enc3 = enc4 = 64;
      } else if (isNaN(chr3)) {
        enc4 = 64;
      }
 
      output = output +
      _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
      _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
 
    }
 
    return output;
}

function gup( name ){
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return"";
	else
		return results[1];
}

function perfil_usuario(){
	window.location = 'perfil_usuario';
}