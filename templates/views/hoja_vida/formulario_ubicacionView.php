<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES.'inc_header.php'; ?>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <!-- page content -->
    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h3 class="mb-0 font-size-11">| <?php echo str_replace('|', '<span class="fas fa-chevron-right text-gray-400 mx-1"></span>', $data['titulo_pagina']); ?></h3>
                            
                        </div>
                    </div>
                </div>
                <form name="form_guardar" id="id_form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data" novalidate>
                <div class="row mb-5">
                    <div class="col-md-3">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center">
                                        <?php require_once INCLUDES.'inc_secciones_hoja_vida.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                            <div class="row mb-5">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mb-2">
                                                    <div class="col-md-12 mb-2">
                                                        <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                        <div class="progress" style="height: 25px;" id="avance_barra">
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-map-location-dot"></span> Información de Ubicación</p>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_ubicacion_ciudad_residencia" class="form-label my-0 font-size-12">Ciudad de residencia</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_ubicacion_ciudad_residencia" id="hvp_ubicacion_ciudad_residencia" <?php echo ($_SESSION[APP_SESSION.'_usuario_add']==1) ? 'disabled' : ''; ?> data-live-search="true" data-container="body" title="Seleccione" onchange="valida_ciudad();" required>
                                                            <?php foreach ($data['resultado_registros_ciudad'] as $registro): ?>
                                                                <option value="<?php echo $registro->ciu_codigo; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hvp_ubicacion_ciudad_residencia==$registro->ciu_codigo) ? 'selected' : ''; ?>><?php echo $registro->ciu_municipio.', '.$registro->ciu_departamento; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="hvp_ubicacion_direccion_residencia" class="form-label my-0 font-size-12">Dirección de residencia</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_direccion_residencia" id="hvp_ubicacion_direccion_residencia" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_ubicacion_direccion_residencia; ?>" required readonly>
                                                            <div class="input-group-append">
                                                                <a href="#" class="btn btn-warning login-btn font-size-11 px-1 py-1" onclick="open_modal_direccion();">Diligenciar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="hvp_ubicacion_maps_latitud" class="form-label my-0 font-size-12">Latitud</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_maps_latitud" id="hvp_ubicacion_maps_latitud" value="<?php echo $data['maps_array'][0]; ?>" required readonly>
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="hvp_ubicacion_maps_longitud" class="form-label my-0 font-size-12">Longitud</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_maps_longitud" id="hvp_ubicacion_maps_longitud" value="<?php echo $data['maps_array'][1]; ?>" required readonly>
                                                    </div>
                                                    
                                                    <input type="hidden" id="hvp_ubicacion_maps_direccion" name="hvp_ubicacion_maps_direccion" readonly>
                                                    <input type="hidden" id="hvp_ubicacion_maps_ciudad" name="hvp_ubicacion_maps_ciudad" readonly>
                                                    <input type="hidden" id="hvp_ubicacion_maps_departamento" name="hvp_ubicacion_maps_departamento" readonly>
                                                    <input type="hidden" id="hvp_ubicacion_maps_pais" name="hvp_ubicacion_maps_pais" readonly>
                                                    <input type="hidden" id="hvp_ubicacion_maps_localidad" name="hvp_ubicacion_maps_localidad" readonly>
                                                    <input type="hidden" id="hvp_ubicacion_maps_barrio" name="hvp_ubicacion_maps_barrio" readonly>
                                                    <input type="hidden" id="hvp_ubicacion_maps_codigo_postal" name="hvp_ubicacion_maps_codigo_postal" readonly>

                                                    <div class="col-md-3 mb-3 <?php echo $data['control_localidad']; ?>" id="hvp_ubicacion_localidad_comuna_div">
                                                        <label for="hvp_ubicacion_localidad_comuna" class="form-label my-0 font-size-12">Localidad</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_ubicacion_localidad_comuna" id="hvp_ubicacion_localidad_comuna" data-live-search="true" data-container="body" title="Seleccione" onchange="valida_localidad();" required <?php echo ($data['control_localidad']=='d-block') ? '' : 'disabled'; ?>>
                                                            <?php foreach ($data['resultado_registros_localidad'] as $registro): ?>
                                                                <option value="<?php echo $registro->ciub_localidad; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hvp_ubicacion_localidad_comuna==$registro->ciub_localidad) ? 'selected' : ''; ?>><?php echo $registro->ciub_localidad; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3 <?php echo $data['control_barrio']; ?>" id="hvp_ubicacion_barrio_div">
                                                        <label for="hvp_ubicacion_barrio" class="form-label my-0 font-size-12">Barrio</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_ubicacion_barrio" id="hvp_ubicacion_barrio" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_ubicacion_barrio; ?>" required <?php echo ($data['control_barrio']=='d-block') ? '' : 'disabled'; ?>>
                                                    </div>
                                                    <div class="col-md-3 mb-3 <?php echo $data['control_barrio_lista']; ?>" id="hvp_ubicacion_barrio_lista_div">
                                                        <label for="hvp_ubicacion_barrio_lista" class="form-label my-0 font-size-12">Barrio</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_ubicacion_barrio_lista" id="hvp_ubicacion_barrio_lista" data-live-search="true" data-container="body" title="Seleccione" required <?php echo ($data['control_barrio_lista']=='d-block') ? '' : 'disabled'; ?>>
                                                            <?php foreach ($data['resultado_registros_barrio'] as $registro): ?>
                                                                <option value="<?php echo $registro->ciub_barrio; ?>" class="font-size-11" <?php echo ($data['resultado_registros_usuario'][0]->hvp_ubicacion_barrio==$registro->ciub_barrio) ? 'selected' : ''; ?>><?php echo $registro->ciub_barrio; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-9 mt-5">
                                                        <p class="alert alert-warning p-1 m-0 font-size-11"><b>Nota:</b> Si la ubicación del mapa no corresponde a tu ubicación real, ubica el marcador en el mapa donde corresponda.</p>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div id="map"></div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-address-book"></span> Información de Contacto</p>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_numero_celular" class="form-label my-0 font-size-12">Número de celular</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_numero_celular" id="hvp_contacto_numero_celular" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_numero_celular; ?>" maxlength="10" minlength="10" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_numero_celular_alternativo" class="form-label my-0 font-size-12">Número de celular alternativo</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_numero_celular_alternativo" id="hvp_contacto_numero_celular_alternativo" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_auxiliar_2; ?>" maxlength="10" minlength="10" autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_correo_personal" class="form-label my-0 font-size-12">Correo electrónico personal</label>
                                                        <input type="email" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_correo_personal" id="hvp_contacto_correo_personal" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_correo_personal; ?>" pattern="[a-zA-Z0-9!#$%&'*\/=?^_`\{\|\}~\+\-]([\.]?[a-zA-Z0-9!#$%&'*\/=?^_`\{\|\}~\+\-])+@[a-zA-Z0-9]([^@&%$\/\(\)=?¿!\.,:;]|\d)+[a-zA-Z0-9][\.][a-zA-Z]{2,4}+[a-zA-Z0-9][\.][a-zA-Z]{2,4}([\.][a-zA-Z]{2})?" title="Ingresa un correo electrónico válido" onchange="valida_correo();" onkeyup="valida_correo();" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_correo_corporativo" class="form-label my-0 font-size-12">Correo electrónico corporativo</label>
                                                        <input type="email" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_correo_corporativo" id="hvp_contacto_correo_corporativo" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_correo_corporativo; ?>" readonly>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-truck-medical"></span> En caso de emergencia avisar a:</p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="alert alert-warning p-1 mt-0 mb-2">Por favor indique 2 personas que podamos contactar en caso de emergencia</p>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_nombres" class="form-label my-0 font-size-12">Nombres</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_nombres" id="hvp_contacto_emergencia_nombres" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_nombres; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_apellidos" class="form-label my-0 font-size-12">Apellidos</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_apellidos" id="hvp_contacto_emergencia_apellidos" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_apellidos; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_parentesco" class="form-label my-0 font-size-12">Parentesco</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_contacto_emergencia_parentesco" id="hvp_contacto_emergencia_parentesco" data-container="body" title="Seleccione" required>
                                                            <option value="Pareja" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco=='Pareja') ? 'selected' : ''; ?>>Pareja</option>
                                                            <option value="Padre" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco=='Padre') ? 'selected' : ''; ?>>Padre</option>
                                                            <option value="Madre" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco=='Madre') ? 'selected' : ''; ?>>Madre</option>
                                                            <option value="Hermano(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco=='Hermano(a)') ? 'selected' : ''; ?>>Hermano(a)</option>
                                                            <option value="Primo(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco=='Primo(a)') ? 'selected' : ''; ?>>Primo(a)</option>
                                                            <option value="Amigo(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco=='Amigo(a)') ? 'selected' : ''; ?>>Amigo(a)</option>
                                                            <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco=='Otro') ? 'selected' : ''; ?>>Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_celular" class="form-label my-0 font-size-12">Número de celular de tu familiar/amigo(a)</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_celular" id="hvp_contacto_emergencia_celular" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_celular; ?>" maxlength="10" minlength="10" required autocomplete="off">
                                                    </div>
                                                    <!-- CONTACTO EMERGENCIA 2 -->
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_nombres_2" class="form-label my-0 font-size-12">Nombres</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_nombres_2" id="hvp_contacto_emergencia_nombres_2" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_nombres_2; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_apellidos_2" class="form-label my-0 font-size-12">Apellidos</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_apellidos_2" id="hvp_contacto_emergencia_apellidos_2" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_apellidos_2; ?>" required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_parentesco_2" class="form-label my-0 font-size-12">Parentesco</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_contacto_emergencia_parentesco_2" id="hvp_contacto_emergencia_parentesco_2" data-container="body" title="Seleccione" required>
                                                            <option value="Pareja" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco_2=='Pareja') ? 'selected' : ''; ?>>Pareja</option>
                                                            <option value="Padre" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco_2=='Padre') ? 'selected' : ''; ?>>Padre</option>
                                                            <option value="Madre" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco_2=='Madre') ? 'selected' : ''; ?>>Madre</option>
                                                            <option value="Hermano(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco_2=='Hermano(a)') ? 'selected' : ''; ?>>Hermano(a)</option>
                                                            <option value="Primo(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco_2=='Primo(a)') ? 'selected' : ''; ?>>Primo(a)</option>
                                                            <option value="Amigo(a)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco_2=='Amigo(a)') ? 'selected' : ''; ?>>Amigo(a)</option>
                                                            <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_parentesco_2=='Otro') ? 'selected' : ''; ?>>Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_contacto_emergencia_celular_2" class="form-label my-0 font-size-12">Número de celular de tu familiar/amigo(a)</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_contacto_emergencia_celular_2" id="hvp_contacto_emergencia_celular_2" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_contacto_emergencia_celular_2; ?>" maxlength="10" minlength="10" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <span id="btn_enviar">
                                                    <a href="<?php echo URL; ?>hoja-vida/formulario-personal/<?php echo base64_encode('personal'); ?>" class="btn btn-warning login-btn">Regresar</a>
                                                    <button type="submit" name="form_guardar" class="btn btn-success login-btn">Guardar y continuar</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- MODAL DETALLE -->
    <div class="modal fade" id="modal-detalle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Asistente para el ingreso de la dirección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-detalle">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger py-2 px-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success d-none" name="btn_guardar_direccion" id="btn_guardar_direccion" data-bs-dismiss="modal" onclick="guardar_direccion();">Guardar dirección</button>
            </div>
        </div>
        </div>
    </div>
<?php require_once INCLUDES.'inc_footer.php'; ?>
<script>
    let map, geocoder, marker;

    function initMap() {
        // Inicializa el mapa centrado en una ubicación predeterminada
        <?php if ($data['maps_array'][0] != '' && $data['maps_array'][1] != ''): ?>
            const defaultLocation = { lat: <?php echo $data['maps_array'][0]; ?>, lng: <?php echo $data['maps_array'][1]; ?> }; // Coordenadas predeterminadas
        <?php else: ?>
            const defaultLocation = { lat: 4.7110, lng: -74.0721 }; // Bogotá, Colombia
        <?php endif; ?>

        // Crear el mapa
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 14,
        });

        geocoder = new google.maps.Geocoder();

        // Agregar un marcador inicial en la ubicación predeterminada
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true, // Permite mover el marcador
        });

        // Actualizar coordenadas y obtener datos al mover el marcador
        marker.addListener('dragend', () => {
            const position = marker.getPosition();
            document.getElementById('hvp_ubicacion_maps_latitud').value = position.lat();
            document.getElementById('hvp_ubicacion_maps_longitud').value = position.lng();

            // Obtener datos adicionales de la ubicación
            obtenerDatosUbicacion(position);
        });

        // Obtener datos iniciales de la ubicación predeterminada
        obtenerDatosUbicacion(defaultLocation);
    }

    // Función para geocodificar una dirección manualmente
    function geocodeAddress() {
        let address = document.getElementById("direccion_completa").value;
        const city_select = document.getElementById("hvp_ubicacion_ciudad_residencia");
        let city = city_select.options[city_select.selectedIndex].text;
        
        address = address + ' ' + city;
        geocoder.geocode({ address: address }, (results, status) => {
            if (status === "OK") {
                // Centrar el mapa y mover el marcador
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);

                // Actualizar las coordenadas
                document.getElementById("hvp_ubicacion_maps_latitud").value = results[0].geometry.location.lat();
                document.getElementById("hvp_ubicacion_maps_longitud").value = results[0].geometry.location.lng();

                // Obtener datos adicionales de la ubicación
                obtenerDatosUbicacion(results[0].geometry.location);
            } else {
                console.error("No se pudo encontrar la dirección: " + status);
            }
        });
    }

    // Función para obtener datos adicionales de la ubicación
    function obtenerDatosUbicacion(latLng) {
        geocoder.geocode({ location: latLng }, (results, status) => {
            if (status === "OK" && results[0]) {
                // Actualizar el campo de dirección completa
                document.getElementById("hvp_ubicacion_maps_direccion").value = results[0].formatted_address;

                // Analizar los componentes de la dirección
                const addressComponents = results[0].address_components;
                let ciudad = "", departamento = "", pais = "", localidad = "", barrio = "", codigo_postal = "";
                // console.log(addressComponents);
                addressComponents.forEach(component => {
                    const types = component.types;

                    if (types.includes("locality")) {
                        ciudad = component.long_name;
                    }
                    if (types.includes("administrative_area_level_1")) {
                        departamento = component.long_name;
                    }
                    if (types.includes("country")) {
                        pais = component.long_name;
                    }
                    if ((types.includes("neighborhood"))) {
                        barrio = component.long_name;
                    }
                    if ((types.includes("postal_code"))) {
                        codigo_postal = component.long_name;
                    }
                    if (types.includes("sublocality") || types.includes("sublocality_level_1")) {
                        localidad = component.long_name;
                    }
                });

                // Actualizar los campos del formulario
                document.getElementById("hvp_ubicacion_maps_ciudad").value = ciudad;
                document.getElementById("hvp_ubicacion_maps_departamento").value = departamento;
                document.getElementById("hvp_ubicacion_maps_pais").value = pais;
                document.getElementById("hvp_ubicacion_maps_localidad").value = localidad;
                document.getElementById("hvp_ubicacion_maps_barrio").value = barrio;
                document.getElementById("hvp_ubicacion_maps_codigo_postal").value = codigo_postal;
            } else {
                console.error("No se pudo obtener los datos: ", status);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATcm4H_cFCegb1VhI6kSckeiy_zu0eqCE&callback=initMap" async defer></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_correo_personal").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toLowerCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_correo_corporativo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toLowerCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_ubicacion_direccion_residencia").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_ubicacion_barrio").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_numero_celular").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_numero_celular_alternativo").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_nombres").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_nombres").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_apellidos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_apellidos").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_celular").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_nombres_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_nombres_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_apellidos_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_apellidos_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_contacto_emergencia_celular_2").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    document.getElementById("id_form_guardar").addEventListener("submit", function(event) {
        let formulario = this;
        let valido = true;

        // Selecciona todos los inputs y selects requeridos que no estén deshabilitados
        let campos = formulario.querySelectorAll("input[required]:not([disabled]), select[required]:not([disabled]), checkbox[required]:not([disabled])");

        campos.forEach(campo => {
            if (campo.type === "checkbox") {
                // Validar checkbox requerido
                if (!campo.checked) {
                    campo.classList.add("is-invalid");
                    campo.classList.remove("is-valid");
                    valido = false;
                    console.log('Ingreso NO valido: '+campo.name);
                } else {
                    campo.classList.add("is-valid");
                    campo.classList.remove("is-invalid");
                }
            } else if (campo.tagName === "SELECT") {
                // Validar select requerido
                let container = campo.closest('.bootstrap-select');
                if (!campo.value || campo.value === "") {
                    campo.classList.add("is-invalid");
                    campo.classList.remove("is-valid");
                    if (container) container.classList.remove("is-valid");
                    if (container) container.classList.add("is-invalid");
                    valido = false;
                    console.log('Ingreso NO valido: '+campo.name);
                } else {
                    campo.classList.add("is-valid");
                    campo.classList.remove("is-invalid");
                    if (container) container.classList.add("is-valid");
                    if (container) container.classList.remove("is-invalid");
                }
            } else {
                // Validar inputs de texto y otros tipos
                if (!campo.value.trim()) {
                    campo.classList.add("is-invalid");
                    campo.classList.remove("is-valid");
                    valido = false;
                    console.log('Ingreso NO valido: '+campo.name);
                } else {
                    campo.classList.add("is-valid");
                    campo.classList.remove("is-invalid");
                }
            }
        });

        if (!valido) {
            console.log('Ingreso NO valido');
            event.preventDefault(); // Evita el envío del formulario si hay errores
        }
    });
</script>
<script type="text/javascript">
    function open_modal_direccion() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').load('<?php echo URL; ?>hoja-vida/formulario-direccion',function(){
            myModal.show();
        });
    }

    function close_modal_direccion() {
        var myModal = new bootstrap.Modal(document.getElementById("modal-detalle"), {});
        $('.modal-body-detalle').html('');
    }

    function guardar_direccion() {
        var direccion_completa = $('#direccion_completa').val();
        $('#hvp_ubicacion_direccion_residencia').val(direccion_completa);
        
        close_modal_direccion();
    }

    function valida_correo() {
        var hvp_contacto_correo_personal = document.getElementById("hvp_contacto_correo_personal").value;
        var hvp_contacto_correo_corporativo = document.getElementById("hvp_contacto_correo_corporativo").value;

        if (hvp_contacto_correo_personal==hvp_contacto_correo_corporativo) {
            alert("El correo electrónico personal no puede ser igual al correo electrónico corporativo");
            document.getElementById("hvp_contacto_correo_personal").value="";
        }
    }

    function valida_ciudad() {
        var formData = new FormData();

        $("#hvp_ubicacion_localidad_comuna_div").removeClass('d-block').addClass('d-none');
        $("#hvp_ubicacion_barrio_lista_div").removeClass('d-block').addClass('d-none');
        $("#hvp_ubicacion_barrio_div").removeClass('d-block').addClass('d-none');

        $('#hvp_ubicacion_localidad_comuna').selectpicker('val', '');
        $('#hvp_ubicacion_localidad_comuna').selectpicker('destroy');
        $('#hvp_ubicacion_localidad_comuna').selectpicker();

        $('#hvp_ubicacion_barrio_lista').selectpicker('val', '');
        $('#hvp_ubicacion_barrio_lista').selectpicker('destroy');
        $('#hvp_ubicacion_barrio_lista').selectpicker();
        document.getElementById('hvp_ubicacion_localidad_comuna').disabled=true;
        document.getElementById('hvp_ubicacion_barrio_lista').disabled=true;
        document.getElementById('hvp_ubicacion_barrio').disabled=true;

        var hvp_ubicacion_ciudad_residencia = document.getElementById("hvp_ubicacion_ciudad_residencia").value;

        if (hvp_ubicacion_ciudad_residencia!="" && (hvp_ubicacion_ciudad_residencia=="11001" || hvp_ubicacion_ciudad_residencia=="05001")) {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/formulario-localidad/'+hvp_ubicacion_ciudad_residencia,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    
                },
                complete:function(data){
                    
                },
                success: function(data){
                    var resp = $.parseJSON(data);
                    $("#hvp_ubicacion_localidad_comuna").html(resp.resultado);
                    $("#hvp_ubicacion_localidad_comuna_div").removeClass('d-none').addClass('d-block');
                    document.getElementById('hvp_ubicacion_localidad_comuna').disabled=false;
                    $('#hvp_ubicacion_localidad_comuna').selectpicker('destroy');
                    $('#hvp_ubicacion_localidad_comuna').selectpicker();
                },
                error: function(data){
                    alert("Problemas al tratar de obtener los datos, por favor verifique e intente nuevamente");
                }
            });
        } else {
            $("#hvp_ubicacion_barrio_div").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_ubicacion_barrio').disabled=false;
        }
    }

    function valida_localidad() {
        var formData = new FormData();

        $("#hvp_ubicacion_barrio_lista_div").removeClass('d-block').addClass('d-none');
        $("#hvp_ubicacion_barrio_div").removeClass('d-block').addClass('d-none');

        $('#hvp_ubicacion_barrio_lista').selectpicker('val', '');
        $('#hvp_ubicacion_barrio_lista').selectpicker('destroy');
        $('#hvp_ubicacion_barrio_lista').selectpicker();
        document.getElementById('hvp_ubicacion_barrio_lista').disabled=true;
        document.getElementById('hvp_ubicacion_barrio').disabled=true;

        var hvp_ubicacion_ciudad_residencia = document.getElementById("hvp_ubicacion_ciudad_residencia").value;
        var hvp_ubicacion_localidad_comuna = document.getElementById("hvp_ubicacion_localidad_comuna").value;

        if (hvp_ubicacion_ciudad_residencia!="" && (hvp_ubicacion_ciudad_residencia=="11001" || hvp_ubicacion_ciudad_residencia=="05001") && hvp_ubicacion_localidad_comuna!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/formulario-barrio/'+hvp_ubicacion_ciudad_residencia+'/'+hvp_ubicacion_localidad_comuna,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    
                },
                complete:function(data){
                    
                },
                success: function(data){
                    var resp = $.parseJSON(data);
                    $("#hvp_ubicacion_barrio_lista").html(resp.resultado);
                    $("#hvp_ubicacion_barrio_lista_div").removeClass('d-none').addClass('d-block');
                    document.getElementById('hvp_ubicacion_barrio_lista').disabled=false;
                    $('#hvp_ubicacion_barrio_lista').selectpicker('destroy');
                    $('#hvp_ubicacion_barrio_lista').selectpicker();
                },
                error: function(data){
                    alert("Problemas al tratar de obtener los datos, por favor verifique e intente nuevamente");
                }
            });
        } else {
            $("#hvp_ubicacion_barrio_div").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_ubicacion_barrio').disabled=false;
        }
    }

</script>

<script type="text/javascript">
    function progreso() {
        var formData = new FormData();

        $.ajax({
            type: 'POST',
            url: '<?php echo URL; ?>hoja-vida/formulario-progreso',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                
            },
            complete:function(data){
                
            },
            success: function(data){
                var resp = $.parseJSON(data);
                $('#status_autorizaciones').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_autorizaciones);
                $('#status_personal').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_personal);
                $('#status_ubicacion').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_ubicacion);
                $('#status_familiar').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_familiar);
                $('#status_salud').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_salud);
                $('#status_intereses').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_intereses);
                $('#status_formacion').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_formacion);
                $('#status_poblaciones').removeClass('seccion-warning').removeClass('seccion-success').addClass(resp.status_poblaciones);
                $('#avance_barra').html(resp.avance_barra);
                $('#avance_total').html(resp.avance_total);
                $('#secciones_total').html(resp.secciones_total);
            },
            error: function(data){
                alert("Problemas al tratar de obtener el progreso, por favor verifique e intente nuevamente");
            }
        });
    }

    progreso();
</script>