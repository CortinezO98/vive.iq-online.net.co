<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES.'inc_header.php'; ?>
    <script>
      tinymce.init({
        selector: '#app_descripcion',
        license_key: 'gpl'
      });
    </script>
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
                <div class="row justify-content-center">
                    <div class="bg-white rounded-3 col-lg-8 col-md-12 col-12">
                        <div class="row mb-5">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="row p-6 d-lg-flex justify-content-between align-items-center ">
                                    <form name="form_guardar" action="" method="post" class="comment-form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12   ">
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <label for="app_id" class="form-label my-0 font-size-11">Id parámetro</label>
                                                        <input type="text" class="form-control form-control-sm" name="app_id" id="app_id" value="<?php echo $data['resultado_registros'][0]->app_id; ?>" required readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label for="app_titulo" class="form-label my-0 font-size-11">Título</label>
                                                        <input type="text" class="form-control form-control-sm" name="app_titulo" id="app_titulo" value="<?php echo $data['resultado_registros'][0]->app_titulo; ?>" required readonly>
                                                    </div>
                                                    <?php if($data['resultado_registros'][0]->app_tipo=='texto'): ?>
                                                        <div class="col-md-12 mb-3">
                                                            <textarea class="form-control form-control-sm" name="app_descripcion" id="app_descripcion" rows="15" maxlength="500"><?php echo $data['resultado_registros'][0]->app_descripcion; ?></textarea>
                                                        </div>
                                                    <?php elseif($data['resultado_registros'][0]->app_tipo=='link'): ?>
                                                        <div class="col-md-12 mb-3">
                                                        <label for="app_descripcion" class="form-label my-0 font-size-11">Link</label>
                                                        <input type="url" class="form-control form-control-sm" name="app_descripcion" id="app_descripcion_link" value="<?php echo $data['resultado_registros'][0]->app_descripcion; ?>" required>
                                                        </div>
                                                    <?php elseif($data['resultado_registros'][0]->app_tipo=='lista'): ?>
                                                        <div class="col-md-12 mt-1" id="opciones_respuestas_opciones_div">
                                                            <div class="form-group my-1">
                                                                <label for="opciones" class="form-label my-0 font-size-11">Opciones</label>
                                                                <div class="row" id="opciones_respuestas_opciones">
                                                                    <?php if(isset($data['array_listas'])): ?>
                                                                        <?php for ($i=0; $i < count($data['array_listas']); $i++): ?>
                                                                            <div class="row lista_opciones px-4 col-md-12">
                                                                                <div class="col-11">
                                                                                    <div class="form-group my-1">
                                                                                        <input type="text" class="form-control form-control-sm font-size-11" name="opciones[]" id="opciones_<?php echo $i; ?>" maxlength="100" value="<?php echo $data['array_listas'][$i]; ?>">
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
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end mt-2">
                                                <button class="btn btn-success float-end ms-1" type="submit" name="form_guardar" id="guardar_registro_btn">Guardar</button>
                                                <?php if(isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>administrador-parametros/ver/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>" class="btn btn-dark float-end">Finalizar</a>
                                                <?php endif; ?>
                                                <?php if(!isset($_POST["form_guardar"])): ?>
                                                    <a href="<?php echo URL; ?>administrador-parametros/ver/<?php echo $data['pagina']; ?>/<?php echo $data['filtro']; ?>" class="btn btn-danger float-end">Cancelar</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>
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