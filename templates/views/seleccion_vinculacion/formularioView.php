<?php require_once INCLUDES.'inc_head.php'; ?>
<!-- container -->
<main class="px-5 d-flex flex-column">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center my-5">
                <h3 class="mb-0 font-size-11">| <?php echo str_replace('|', '<span class="fas fa-chevron-right text-gray-400 mx-1"></span>', $data['titulo_pagina']); ?></h3>
            </div>
        </div>
    </div>
    <form name="form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data">
    <div class="row justify-content-center mb-2">
        <?php if($data['valida_token']): ?>
            <div class="col-md-3">
                <div class="bg-white rounded-3 col-lg-12 col-md-12 col-12">
                    <div class="row mb-5">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row p-6 d-lg-flex justify-content-between align-items-center">
                                <div class="col-md-12">
                                    <p class="alert alert-corp p-1 font-size-11 my-0"><span class="fas fa-info-circle"></span> Información Aspirante</p>
                                    <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-user-tie"></span> <?php echo $data['resultado_aspirante'][0]->hva_nombres.' '.$data['resultado_aspirante'][0]->hva_apellido_1.' '.$data['resultado_aspirante'][0]->hva_apellido_2; ?></p>
                                    <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-address-card"></span> <?php echo $data['resultado_aspirante'][0]->hva_identificacion; ?></p>
                                    <!-- <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-mobile"></span> <?php echo $data['resultado_aspirante'][0]->hva_celular; ?></p> -->
                                    <p class="appoinment-content-text mt-0 my-0 py-1 px-2"><span class="fas fa-envelope"></span> <?php echo $data['resultado_aspirante'][0]->hva_correo; ?></p>
                                </div>
                                
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
                                            <div class="col-md-2 text-start">
                                                <img src="<?php echo IMAGES; ?><?php echo LOGO; ?>" class="mb-2 img-fluid"></a>
                                            </div>
                                            <div class="col-md-10">
                                                <label for="">Progreso</label><span class="float-end">Completado: <span id="avance_total"></span> de <span id="secciones_total"></span></span>
                                                <div class="progress" style="height: 25px;" id="avance_barra">
                                                    
                                                </div>
                                            </div>
                                            <hr class="my-3">
                                            <h3>Instrucciones para diligenciamiento de la hoja de vida:</h3>
                                            <?php if($data['valida_token']): ?>
                                                <?php if($data['valida_oferta']): ?>
                                                    <div class="col-md-12 appoinment-content-text mt-0 mb-2">
                                                        <ol>
                                                            <li class="my-2">Diligencia todos los campos.</li>
                                                            <li class="my-2">Evita interrumpir el diligenciamiento de la información para no tener bloqueos.</li>
                                                            <li class="my-2">En información familiar, te invitamos a diligenciar la información de  tu grupo familiar más cercano.</li>
                                                            <li class="my-2">En información de estudios, te invitamos a diligenciar la información de todos tus estudios.</li>
                                                            <li class="my-2">Cuando vayas a adjuntar tu documento de identidad corrobora que sea legible.</li>
                                                        </ol>
                                                    </div>
                                                    <!-- <p class="appoinment-content-text mt-0 mb-2">Texto de bienvenida, instrucciones y demás para iniciar el proceso de registro de hora de vida digital con IQ<br><br><br><br><br><br></p> -->
                                                <?php else: ?>
                                                    <div class="col-md-12 my-2">
                                                        <p class="alert alert-warning p-1">¡No hemos podido validar la oferta, por favor intente nuevamente!</p>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="col-md-12 my-2">
                                                    <p class="alert alert-warning p-1">¡No hemos podido validar el token, por favor intenta nuevamente!</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php echo Flasher::flash(); ?>
                                    <div class="col-md-12 text-end">
                                        <?php if($data['valida_token'] AND $data['valida_oferta']): ?>
                                            <a href="<?php echo URL; ?>seleccion-vinculacion/formulario-personal<?php echo $data['path_add']; ?>" class="btn btn-dark login-btn mt-1">Continuar</a>
                                        <?php else: ?>
                                            <a href="https://www.iqoutsourcing.com/" class="btn btn-dark login-btn mt-1">Finalizar</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-12 my-2">
                <p class="alert alert-warning p-1">¡No hemos podido validar el token, por favor intenta nuevamente!</p>
            </div>
        <?php endif; ?>
    </div>
    </form>
</main>
<?php require_once INCLUDES.'inc_footer_index.php'; ?>
<script type="text/javascript">
    function progreso() {
        var id_oferta = '<?php echo $data['id_oferta']; ?>';
        var token = '<?php echo $data['id_token']; ?>';

        var formData = new FormData();

        if (token!="" && id_oferta!="") {
            $.ajax({
                type: 'POST',
                url: '<?php echo URL; ?>seleccion-vinculacion/formulario-progreso/'+id_oferta+'/'+token,
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
                    $('#avance_barra').html(resp.avance_barra);
                    $('#avance_total').html(resp.avance_total);
                    $('#secciones_total').html(resp.secciones_total);

                    if (resp.control_envio) {
                        $('#btn_enviar').html(resp.control_envio_string);
                    }
                },
                error: function(data){
                    alert("Problemas al tratar de obtener el progreso, por favor verifique e intente nuevamente");
                }
            });
        } else {
            alert("Problemas al tratar de obtener el progreso, por favor verifique e intente nuevamente");
        }
    }

    progreso();
</script>