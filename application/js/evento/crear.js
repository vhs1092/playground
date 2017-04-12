/*
function addDate(e){
    alert(3);
                $(e).datepicker();

}

function addTime(e){
    $(e).datepicker();

}*/


        $(document).ready(function() {
            

     


           // $(".times").pickatime();
            //$(".times").pickatime();
    
            //$(".dates").pickadate({format: 'mmmm, d yyyy', formatSubmit: 'yyyy-mm-dd'});
            //$(".dates").pickadate({format: 'mmmm, d yyyy', formatSubmit: 'yyyy-mm-dd'});
           // $(".dates").datepicker();



            var latlng = new google.maps.LatLng(20.2923, 85.8191);
            var map = new google.maps.Map(document.getElementById('myMap'), {
                center: latlng,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'move and pin exact point of your property',
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(a) {

                var sonuc1 = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4);
                $('#latitude').val(a.latLng.lat().toFixed(4));
            $('#longitude').val(a.latLng.lng().toFixed(4));
            
                $('#loc').val(sonuc1);
            });

            function placeMarker(location) {


                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        title: 'move and pin exact point of your property'
                    });
                }
            }

            google.maps.event.addListener(map, 'click', function(event) {

                placeMarker(event.latLng);
                var sonuc2 = event.latLng.lat().toFixed(4) + ', ' + event.latLng.lng().toFixed(4);
                $('#latitude').val(event.latLng.lat().toFixed(4));
                $('#longitude').val(event.latLng.lng().toFixed(4));

                $('#loc').val(sonuc2);
            });

        });


        $("#il").change(function() {
            var val = $('#il option:selected').val();
            var sonuc3 = (val);
            $('#sonucx').html(sonuc3);
            var mappos = document.getElementById("il").options[document.getElementById("il").selectedIndex].getAttribute('latLng');
            var latlngStr = mappos.split(',', 2);
            var lat = parseFloat(latlngStr[0]);
            var lng = parseFloat(latlngStr[1]);

            var latlng = new google.maps.LatLng(lat, lng);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: latlng,
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'pin exact point of your property',
                draggable: true
            });

            var sonuc4 = lat + "," + lng;
            $('#latitude').val(lat);
            $('#longitude').val(lng);

            google.maps.event.addListener(marker, 'dragend', function(a) {
                var sonuc6 = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4);
                $('#loc').val(sonuc6);
            });

            function placeMarker(location) {
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        title: 'move and pin exact point of your property'
                    });
                }
            }

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
                var sonuc5 = event.latLng.lat().toFixed(4) + ', ' + event.latLng.lng().toFixed(4);
                $('#loc').val(sonuc5);
            });



        });

        $('body').on('focus',".dates", function(){
    $(this).pickadate({format: 'yyyy-mm-dd'});

});

$('body').on('focus',".times", function(){
    $(this).pickatime();

});

function addMore() {
            $("#product").append('<div id="inputs" class="col-lg-12"><div class="product-item float-clear col-lg-12" style="clear:both;"><div class="float-left col-lg-1"><input type="checkbox" name="item_index[]" /></div><div  class="col-lg-11"><div class="float-left col-lg-3"><input placeholder="start date" type="text" class="dates" name="fecha_inicio[]" /></div><div class="float-left col-lg-3"><input placeholder="end date" type="text" class="dates" name="fecha_fin[]" /></div><div class="float-left col-lg-3"><input placeholder="start time" type="text" class="times" name="hora_inicio[]" /></div><div class="float-left col-lg-3"><input placeholder="end date" type="text" class="times" name="hora_fin[]" /></div></div></div></div>');
    
}
function deleteRow() {
    $('div.product-item').each(function(index, item){
        jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
                $(item).remove();
            }
        });
    });
}

    $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 10,
        nav: false,
        items: 1
    })