<div class="row justify-content-center mb-2">
    <div class="col-md-12">
        <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
            <div class="row mb-5">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="blog__item2-title mb-0 pb-0">
                                    <button type="button" class="btn-close float-end" id="pc_close" data-bs-dismiss="modal" aria-label="Close" onclick="close_modal_preguntas();"></button>
                                    <h5 class="my-0 py-0 font-size-12"><?php echo $data['tipo_titulo']; ?></h5>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group my-1">
                                    <label for="pregunta" class="form-label my-0 font-size-11">Pregunta</label>
                                    <textarea class="form-control" name="pregunta" id="pregunta" rows="4" <?php echo ($data['accion']=='eliminar') ? 'readonly' : ''; ?>><?php echo $data['resultado_pregunta'][0]['encp_pregunta']; ?></textarea>
                                </div>
                            </div>

                            <?php if($data['tipo']=='opcion_multiple' OR $data['tipo']=='lista_desplegable'): ?>
                                <div class="col-md-12 mt-1" id="opciones_respuestas_opciones_div">
                                    <div class="form-group my-1">
                                        <label for="opciones" class="form-label my-0 font-size-11">Opciones</label>
                                        <div class="row" id="opciones_respuestas_opciones">
                                            <?php if(isset($data['resultado_pregunta_opciones'])): ?>
                                                <?php for ($i=0; $i < count($data['resultado_pregunta_opciones']); $i++): ?>
                                                    <div class="row lista_opciones px-4 col-md-12">
                                                        <div class="col-11">
                                                            <div class="form-group my-1">
                                                                <input type="text" class="form-control form-control-sm font-size-11" name="opciones[]" id="opciones_<?php echo $i; ?>" maxlength="100" value="<?php echo $data['resultado_pregunta_opciones'][$i]; ?>" <?php echo ($data['accion']=='eliminar') ? 'readonly' : ''; ?>>
                                                            </div>
                                                        </div>
                                                        <div class="col-1 pt-1">
                                                            <a href="#" class="font-size-11 p-0 text-danger"  id="del_field" title="Quitar opción"><span class="fas fa-trash-alt"></span></a>
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            <?php endif; ?>
                                        </div>
                                        <a href="#" class="btn btn-primary font-size-11 p-0 mt-1" style="display: block; width: 185px;" id="add_field" title="Añadir opción"><span class="fas fa-plus"></span> Añadir opción</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-12 respuesta_contenido"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var campos_max = 100;

    var x = 0;
    $('#add_field').click (function(e) {
        e.preventDefault();
        if (x < campos_max) {
            $('#opciones_respuestas_opciones').append('<div class="row lista_opciones px-4 col-md-12">\
                <div class="col-11">\
                    <div class="form-group my-1">\
                        <input type="text" class="form-control form-control-sm font-size-11" name="opciones[]" id="opciones_'+x+'" maxlength="100" value="">\
                    </div>\
                </div>\
                <div class="col-1 pt-1">\
                    <a href="#" class="font-size-11 p-0 text-danger" id="del_field" title="Quitar opción"><span class="fas fa-trash-alt"></span></a>\
                </div>\
            </div>');
            x++;
        }
    });

    $('#opciones_respuestas_opciones').on("click","#del_field",function(e) {
        e.preventDefault();
        $(this).parents('div.lista_opciones').remove();
        x--;
    });
</script>
<script>
    var id_encuesta = '<?php echo $data['id_encuesta']; ?>';
    var tipo = '<?php echo $data['tipo']; ?>';
    var accion = '<?php echo $data['accion']; ?>';
    var id_pregunta = '<?php echo $data['id_pregunta']; ?>';
    function guardar() {
        var btnEnviar = $('#btnEnviar');
        var btnCancelar = $('#btnCancelar');
        var formData = new FormData();
        formData.append("id_encuesta", id_encuesta);
        formData.append("tipo", tipo);
        formData.append("accion", accion);
        formData.append("id_pregunta", id_pregunta);
        
        var pregunta = $("#pregunta").val();
        
        formData.append("pregunta", pregunta);
        if (tipo=='opcion_multiple' || tipo=='lista_desplegable') {
            // Obtener todos los elementos con el nombre "opciones[]"
            var opcionesInputs = document.querySelectorAll('input[name="opciones[]"]');

            // Iterar sobre los elementos y obtener sus valores
            var valoresOpciones = [];
            opcionesInputs.forEach(function(input) {
                valoresOpciones.push(input.value);
                formData.append("opciones[]", input.value);
            });
            
            
            // var opcion_a = $("#opcion_a").val();
            // formData.append("opcion_a", opcion_a);

            // if(accion=='editar') {
            //     var opcion_a_id = $("#opcion_a_id").val();
            //     var opcion_b_id = $("#opcion_b_id").val();
            //     var opcion_c_id = $("#opcion_c_id").val();
            //     var opcion_d_id = $("#opcion_d_id").val();
            //     formData.append("opcion_a_id", opcion_a_id);
            //     formData.append("opcion_b_id", opcion_b_id);
            //     formData.append("opcion_c_id", opcion_c_id);
            //     formData.append("opcion_d_id", opcion_d_id);
            // }
        }

        if (tipo!="" & pregunta!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>encuestas/configuracion-preguntas-accion',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('#pregunta').prop("disabled", true);
                    // if (tipo=='opcion_multiple_mr') {
                    //     $('#respuesta_correcta_a').prop("disabled", true);
                    //     $('#respuesta_correcta_b').prop("disabled", true);
                    //     $('#respuesta_correcta_c').prop("disabled", true);
                    //     $('#respuesta_correcta_d').prop("disabled", true);
                    // } else {
                    //     $('#respuesta_correcta').prop("disabled", true);
                    // }
                    // $('#p_fpositivo').prop("disabled", true);
                    // if (tipo=='opcion_multiple' || tipo=='opcion_multiple_mr') {
                    //     $("#opcion_a").prop("disabled", true);
                    //     $("#opcion_b").prop("disabled", true);
                    //     $("#opcion_c").prop("disabled", true);
                    //     $("#opcion_d").prop("disabled", true);
                    // }

                    btnEnviar.prop("disabled", true);
                    btnCancelar.prop("disabled", true);

                    $('.respuesta_contenido').html("<p class='alert alert-warning p-1 text-center font-size-11'>¡Cargando, por favor espere!</p>");
                },
                complete:function(data){
                },
                success: function(data){
                    var resp = $.parseJSON(data);
                    $('.respuesta_contenido').html(resp.resultado);
                        
                    if (resp.resultado_valor) {
                        btnEnviar.prop("disabled", true);
                        btnCancelar.removeAttr("disabled");
                        $('#pregunta').prop("disabled", true);
                        // if (tipo=='opcion_multiple_mr') {
                        //     $('#respuesta_correcta_a').prop("disabled", true);
                        //     $('#respuesta_correcta_b').prop("disabled", true);
                        //     $('#respuesta_correcta_c').prop("disabled", true);
                        //     $('#respuesta_correcta_d').prop("disabled", true);
                        // } else {
                        //     $('#respuesta_correcta').prop("disabled", true);
                        // }
                        // if (tipo=='opcion_multiple' || tipo=='opcion_multiple_mr') {
                        //     $("#opcion_a").prop("disabled", true);
                        //     $("#opcion_b").prop("disabled", true);
                        //     $("#opcion_c").prop("disabled", true);
                        //     $("#opcion_d").prop("disabled", true);
                        // }
                    } else {
                        btnEnviar.removeAttr("disabled");
                        btnCancelar.removeAttr("disabled");
                        $('#pregunta').removeAttr("disabled");
                        // if (tipo=='opcion_multiple' || tipo=='opcion_multiple_mr') {
                        //     $("#opcion_a").removeAttr("disabled");
                        //     $("#opcion_b").removeAttr("disabled");
                        //     $("#opcion_c").removeAttr("disabled");
                        //     $("#opcion_d").removeAttr("disabled");
                        // }
                    }
                },
                error: function(data){
                    alert("Problemas al tratar de editar el registro, por favor verifica e intenta nuevamente");
                }
            });
        } else {
            alert("¡Problemas al editar el registro, por favor verifica e intenta nuevamente!");
        }
    }
</script>