<div class="col-md-12">
    <p class="alert alert-corp px-2 py-1 mt-0 mb-3 font-size-11"><span class="fas fa-list-ol"></span> Secciones</p>
</div>
<div class="col-md-12 px-4 mb-2">
    <?php if($data['resultado_registros_usuario_count']>0 OR $modo_secciones=='lectura'): ?>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('instrucciones');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-instrucciones/<?php echo base64_encode('instrucciones'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='instrucciones')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block" id="status_autorizaciones">
            <span class="fas fa-file-signature"></span> Autorizaciones
        </a>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('personal');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-personal/<?php echo base64_encode('personal'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='personal')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block seccion-success" id="status_personal">
            <span class="fas fa-address-card"></span> Información Personal
        </a>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('ubicacion');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-ubicacion/<?php echo base64_encode('ubicacion'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='ubicacion')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block" id="status_ubicacion">
            <span class="fas fa-map-location-dot"></span> Ubicación y Contacto
        </a>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('socioeconomico');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-socioeconomico/<?php echo base64_encode('socioeconomico'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='socioeconomico')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block" id="status_familiar">
            <span class="fas fa-people-roof"></span> Socioeconómico y Familiar
        </a>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('salud-bienestar');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-salud-bienestar/<?php echo base64_encode('salud-bienestar'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='salud-bienestar')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block" id="status_salud">
            <span class="fas fa-person-swimming"></span> Salud y Bienestar
        </a>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('intereses-habitos');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-intereses-habitos/<?php echo base64_encode('intereses-habitos'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='intereses-habitos')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block" id="status_intereses">
            <span class="fas fa-person-walking-luggage"></span> Intereses y Hábitos
        </a>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('formacion');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-formacion/<?php echo base64_encode('formacion'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='formacion')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block" id="status_formacion">
            <span class="fas fa-graduation-cap"></span> Formación y Habilidades
        </a>
        <a 
            <?php if($modo_secciones=='lectura'): ?>
                onclick="mostrar_seccion('poblaciones');"
            <?php else: ?>
                href="<?php echo URL; ?>hoja-vida/formulario-poblaciones/<?php echo base64_encode('poblaciones'); ?>"
            <?php endif; ?>
                class="btn <?php echo ($data['menu_opcion']=='poblaciones')? 'btn-dark' : 'btn-outline-dark'; ?> px-2 font-size-11 py-1 text-start mt-1 d-block" id="status_poblaciones">
            <span class="fas fa-users"></span> Poblaciones y Relaciones Familiares
        </a>
    <?php else: ?>
        <p class="alert alert-warning p-1 font-size-11">¡No encontramos secciones habilitadas para la Hoja de Vida, por favor verifique!</p>

    <?php endif; ?>
</div>
<script type="text/javascript">
    function mostrar_seccion(seccion) {
        var id_aspirante = '<?php echo $data['id_registro']; ?>';

        var formData = new FormData();
        formData.append("id_aspirante", id_aspirante);
        formData.append("seccion", seccion);

        if (id_aspirante!="" && seccion!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>hoja-vida/mostrar-seccion',
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

                    if (resp.resultado_valor) {
                        $('#secciones_hoja_vida_detalle').html(resp.resultado_lista);

                        progreso();
                    } else {
                        $('#secciones_hoja_vida_detalle').html('<p class="alert alert-warning p-1 font-size-11">¡No se encontraron registros para la sección seleccionada!</p>');
                    }
                },
                error: function(data){
                    alert("Problemas al tratar de obtener la información, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("Problemas al tratar de obtener la información, por favor verifique e intente nuevamente");
        }
    }

    function progreso() {
        var formData = new FormData();

        $.ajax({
            type: 'POST',
            url: '<?php echo URL; ?>hoja-vida/formulario-progreso/<?php echo $data['id_registro']; ?>',
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

    // mostrar_seccion('instrucciones');
</script>