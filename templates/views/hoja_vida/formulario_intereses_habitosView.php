<?php require_once INCLUDES.'inc_head.php'; ?>
<main id="main-wrapper" class="main-wrapper">
    <?php require_once INCLUDES.'inc_header.php'; ?>
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
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-person-walking"></span> ¿Cuáles son tus hobbies?</p>
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="hvp_interes_habitos_hobbies_deportes" class="form-label my-0 font-size-12">Deportes</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_deportes" id="hvp_interes_habitos_hobbies_deportes" onchange="valida_hdeportes();" data-container="body" title="Seleccione" multiple required>
                                                            <option value="Fútbol" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes=='Fútbol') ? 'selected' : ''; ?>>Fútbol</option>
                                                            <option value="Baloncesto" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes=='Baloncesto') ? 'selected' : ''; ?>>Baloncesto</option>
                                                            <option value="Natación" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes=='Natación') ? 'selected' : ''; ?>>Natación</option>
                                                            <option value="Running" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes=='Running') ? 'selected' : ''; ?>>Running</option>
                                                            <option value="Patinaje" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes=='Patinaje') ? 'selected' : ''; ?>>Patinaje</option>
                                                            <option value="Ninguno" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes=='Ninguno') ? 'selected' : ''; ?>>Ninguno</option>
                                                            <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes=='Otro') ? 'selected' : ''; ?>>Otro</option>    
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_deportes_frecuencia">
                                                        <label for="hvp_interes_habitos_hobbies_deportes_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_deportes_frecuencia" id="hvp_interes_habitos_hobbies_deportes_frecuencia" data-container="body" title="Seleccione" required disabled>
                                                            <option value="Diario" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes_frecuencia=='Diario') ? 'selected' : ''; ?>>Diario</option>
                                                            <option value="Varias veces por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes_frecuencia=='Varias veces por semana') ? 'selected' : ''; ?>>Varias veces por semana</option>
                                                            <option value="Una vez por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes_frecuencia=='Una vez por semana') ? 'selected' : ''; ?>>Una vez por semana</option>
                                                            <option value="Ocasionalmente" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes_frecuencia=='Ocasionalmente') ? 'selected' : ''; ?>>Ocasionalmente</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_deportes_cual">
                                                        <label for="hvp_interes_habitos_hobbies_deportes_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_deportes_cual" id="hvp_interes_habitos_hobbies_deportes_cual" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes_cual; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="hvp_interes_habitos_hobbies_aire" class="form-label my-0 font-size-12">Actividades al aire libre</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_aire" id="hvp_interes_habitos_hobbies_aire" onchange="valida_haire();" data-container="body" title="Seleccione" multiple required>
                                                            <option value="Senderismo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire=='Senderismo') ? 'selected' : ''; ?>>Senderismo</option>
                                                            <option value="Ciclismo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire=='Ciclismo') ? 'selected' : ''; ?>>Ciclismo</option>
                                                            <option value="Camping" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire=='Camping') ? 'selected' : ''; ?>>Camping</option>
                                                            <option value="Pesca" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire=='Pesca') ? 'selected' : ''; ?>>Pesca</option>
                                                            <option value="Ninguno" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire=='Ninguno') ? 'selected' : ''; ?>>Ninguno</option>
                                                            <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire=='Otro') ? 'selected' : ''; ?>>Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_aire_frecuencia">
                                                        <label for="hvp_interes_habitos_hobbies_aire_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_aire_frecuencia" id="hvp_interes_habitos_hobbies_aire_frecuencia" data-container="body" title="Seleccione" required disabled>
                                                            <option value="Diario" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire_frecuencia=='Diario') ? 'selected' : ''; ?>>Diario</option>
                                                            <option value="Varias veces por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire_frecuencia=='Varias veces por semana') ? 'selected' : ''; ?>>Varias veces por semana</option>
                                                            <option value="Una vez por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire_frecuencia=='Una vez por semana') ? 'selected' : ''; ?>>Una vez por semana</option>
                                                            <option value="Ocasionalmente" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire_frecuencia=='Ocasionalmente') ? 'selected' : ''; ?>>Ocasionalmente</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_aire_cual">
                                                        <label for="hvp_interes_habitos_hobbies_aire_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_aire_cual" id="hvp_interes_habitos_hobbies_aire_cual" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_aire_cual; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="hvp_interes_habitos_hobbies_arte" class="form-label my-0 font-size-12">Arte y creatividad</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_arte" id="hvp_interes_habitos_hobbies_arte" onchange="valida_harte();" data-container="body" title="Seleccione" multiple required>
                                                            <option value="Pintura" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte=='Pintura') ? 'selected' : ''; ?>>Pintura</option>
                                                            <option value="Dibujo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte=='Dibujo') ? 'selected' : ''; ?>>Dibujo</option>
                                                            <option value="Escritura" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte=='Escritura') ? 'selected' : ''; ?>>Escritura</option>
                                                            <option value="Música" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte=='Música') ? 'selected' : ''; ?>>Música</option>
                                                            <option value="Ninguno" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte=='Ninguno') ? 'selected' : ''; ?>>Ninguno</option>
                                                            <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte=='Otro') ? 'selected' : ''; ?>>Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_arte_frecuencia">
                                                        <label for="hvp_interes_habitos_hobbies_arte_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_arte_frecuencia" id="hvp_interes_habitos_hobbies_arte_frecuencia" data-container="body" title="Seleccione" required disabled>
                                                            <option value="Diario" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte_frecuencia=='Diario') ? 'selected' : ''; ?>>Diario</option>
                                                            <option value="Varias veces por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte_frecuencia=='Varias veces por semana') ? 'selected' : ''; ?>>Varias veces por semana</option>
                                                            <option value="Una vez por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte_frecuencia=='Una vez por semana') ? 'selected' : ''; ?>>Una vez por semana</option>
                                                            <option value="Ocasionalmente" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte_frecuencia=='Ocasionalmente') ? 'selected' : ''; ?>>Ocasionalmente</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_arte_instrumento">
                                                        <label for="hvp_interes_habitos_hobbies_arte_instrumento" class="form-label my-0 font-size-12">¿Cuál instrumento tocas?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_arte_instrumento" id="hvp_interes_habitos_hobbies_arte_instrumento" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte_instrumento; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_arte_cual">
                                                        <label for="hvp_interes_habitos_hobbies_arte_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_arte_cual" id="hvp_interes_habitos_hobbies_arte_cual" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_arte_cual; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="hvp_interes_habitos_hobbies_tecnologia" class="form-label my-0 font-size-12">Tecnología</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_tecnologia" id="hvp_interes_habitos_hobbies_tecnologia" onchange="valida_htecnologia();" data-container="body" title="Seleccione" multiple required>
                                                            <option value="Programación" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia=='Programación') ? 'selected' : ''; ?>>Programación</option>
                                                            <option value="Diseño gráfico" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia=='Diseño gráfico') ? 'selected' : ''; ?>>Diseño gráfico</option>
                                                            <option value="Videojuegos" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia=='Videojuegos') ? 'selected' : ''; ?>>Videojuegos</option>
                                                            <option value="Ninguno" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia=='Ninguno') ? 'selected' : ''; ?>>Ninguno</option>
                                                            <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia=='Otro') ? 'selected' : ''; ?>>Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_tecnologia_frecuencia">
                                                        <label for="hvp_interes_habitos_hobbies_tecnologia_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_tecnologia_frecuencia" id="hvp_interes_habitos_hobbies_tecnologia_frecuencia" data-container="body" title="Seleccione" required disabled>
                                                            <option value="Diario" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia_frecuencia=='Diario') ? 'selected' : ''; ?>>Diario</option>
                                                            <option value="Varias veces por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia_frecuencia=='Varias veces por semana') ? 'selected' : ''; ?>>Varias veces por semana</option>
                                                            <option value="Una vez por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia_frecuencia=='Una vez por semana') ? 'selected' : ''; ?>>Una vez por semana</option>
                                                            <option value="Ocasionalmente" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia_frecuencia=='Ocasionalmente') ? 'selected' : ''; ?>>Ocasionalmente</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_tecnologia_cual">
                                                        <label for="hvp_interes_habitos_hobbies_tecnologia_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_tecnologia_cual" id="hvp_interes_habitos_hobbies_tecnologia_cual" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_tecnologia_cual; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="hvp_interes_habitos_hobbies_otro" class="form-label my-0 font-size-12">Otros</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_otro" id="hvp_interes_habitos_hobbies_otro" onchange="valida_hotros();" data-container="body" title="Seleccione" multiple required>
                                                            <option value="Lectura" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro=='Lectura') ? 'selected' : ''; ?>>Lectura</option>
                                                            <option value="Cocina" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro=='Cocina') ? 'selected' : ''; ?>>Cocina</option>
                                                            <option value="Idiomas" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro=='Idiomas') ? 'selected' : ''; ?>>Idiomas</option>
                                                            <option value="Ninguno" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro=='Ninguno') ? 'selected' : ''; ?>>Ninguno</option>
                                                            <option value="Otro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro=='Otro') ? 'selected' : ''; ?>>Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_otro_frecuencia">
                                                        <label for="hvp_interes_habitos_hobbies_otro_frecuencia" class="form-label my-0 font-size-12">¿Con qué frecuencia practicas este hobbie?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_otro_frecuencia" id="hvp_interes_habitos_hobbies_otro_frecuencia" data-container="body" title="Seleccione" required disabled>
                                                            <option value="Diario" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro_frecuencia=='Diario') ? 'selected' : ''; ?>>Diario</option>
                                                            <option value="Varias veces por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro_frecuencia=='Varias veces por semana') ? 'selected' : ''; ?>>Varias veces por semana</option>
                                                            <option value="Una vez por semana" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro_frecuencia=='Una vez por semana') ? 'selected' : ''; ?>>Una vez por semana</option>
                                                            <option value="Ocasionalmente" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro_frecuencia=='Ocasionalmente') ? 'selected' : ''; ?>>Ocasionalmente</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3 d-none" id="div_hvp_interes_habitos_hobbies_otro_cual">
                                                        <label for="hvp_interes_habitos_hobbies_otro_cual" class="form-label my-0 font-size-12">¿Cuál?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_hobbies_otro_cual" id="hvp_interes_habitos_hobbies_otro_cual" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_otro_cual; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_interes_habitos_hobbies_recibir_informacion" class="form-label my-0 font-size-12">¿Te gustaría recibir información sobre eventos o actividades relacionadas con tus hobbies?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_hobbies_recibir_informacion" id="hvp_interes_habitos_hobbies_recibir_informacion" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_recibir_informacion=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_recibir_informacion=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="alert alert-corp p-1 mt-0 mb-2"><span class="fas fa-person-walking-luggage"></span> Información de Intereses y Hábitos</p>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="hvp_interes_habitos_actividades_familia" class="form-label my-0 font-size-12">¿Cuáles actividades te gusta hacer en familia?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_actividades_familia" id="hvp_interes_habitos_actividades_familia" data-container="body" title="Seleccione" multiple required>
                                                            <option value="Senderismo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Senderismo') ? 'selected' : ''; ?>>Senderismo</option>
                                                            <option value="Picnic" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Picnic') ? 'selected' : ''; ?>>Picnic</option>
                                                            <option value="Ciclismo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Ciclismo') ? 'selected' : ''; ?>>Ciclismo</option>
                                                            <option value="Natación" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Natación') ? 'selected' : ''; ?>>Natación</option>
                                                            <option value="Deportes al aire libre" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Deportes al aire libre') ? 'selected' : ''; ?>>Deportes al aire libre</option>
                                                            <option value="Camping" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Camping') ? 'selected' : ''; ?>>Camping</option>
                                                            <option value="Observación de aves" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Observación de aves') ? 'selected' : ''; ?>>Observación de aves</option>
                                                            <option value="Jardinería" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Jardinería') ? 'selected' : ''; ?>>Jardinería</option>
                                                            <option value="Noche de juegos de mesa" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Noche de juegos de mesa') ? 'selected' : ''; ?>>Noche de juegos de mesa</option>
                                                            <option value="Noche de películas" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Noche de películas') ? 'selected' : ''; ?>>Noche de películas</option>
                                                            <option value="Cocinar juntos" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Cocinar juntos') ? 'selected' : ''; ?>>Cocinar juntos</option>
                                                            <option value="Manualidades" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Manualidades') ? 'selected' : ''; ?>>Manualidades</option>
                                                            <option value="Leer juntos" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Leer juntos') ? 'selected' : ''; ?>>Leer juntos</option>
                                                            <option value="Karaoke" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Karaoke') ? 'selected' : ''; ?>>Karaoke</option>
                                                            <option value="Noche de talentos" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Noche de talentos') ? 'selected' : ''; ?>>Noche de talentos</option>
                                                            <option value="Visitar un museo" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Visitar un museo') ? 'selected' : ''; ?>>Visitar un museo</option>
                                                            <option value="Ir al teatro" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Ir al teatro') ? 'selected' : ''; ?>>Ir al teatro</option>
                                                            <option value="Asistir a un concierto" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Asistir a un concierto') ? 'selected' : ''; ?>>Asistir a un concierto</option>
                                                            <option value="Visitar un zoológico o acuario" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Visitar un zoológico o acuario') ? 'selected' : ''; ?>>Visitar un zoológico o acuario</option>
                                                            <option value="Ir a un parque de atracciones" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Ir a un parque de atracciones') ? 'selected' : ''; ?>>Ir a un parque de atracciones</option>
                                                            <option value="Visitar un lugar histórico" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Visitar un lugar histórico') ? 'selected' : ''; ?>>Visitar un lugar histórico</option>
                                                            <option value="Viajar " <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Viajar ') ? 'selected' : ''; ?>>Viajar </option>
                                                            <option value="Otros" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_familia=='Otros') ? 'selected' : ''; ?>>Otros</option>
                                                            
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_interes_habitos_actividades_deportivas" class="form-label my-0 font-size-12">¿Realizas actividades deportivas?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_actividades_deportivas" id="hvp_interes_habitos_actividades_deportivas" data-container="body" title="Seleccione" onchange="valida_deporte();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_deportivas=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_deportivas=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3 d-none" id="div_hvp_interes_habitos_actividades_deportivas_cual">
                                                        <label for="hvp_interes_habitos_actividades_deportivas_cual" class="form-label my-0 font-size-12">¿Cuál actividad deportiva realizas?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_actividades_deportivas_cual" id="hvp_interes_habitos_actividades_deportivas_cual" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_actividades_deportivas_cual; ?>" required disabled>
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label for="hvp_interes_habitos_medio_transporte" class="form-label my-0 font-size-12">¿Cuál es tu medio de transporte cuando vas a la oficina?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_medio_transporte" id="hvp_interes_habitos_medio_transporte" data-container="body" title="Seleccione" multiple required>
                                                            <option value="A pie" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='A pie') ? 'selected' : ''; ?>>A pie</option>
                                                            <option value="Bicicleta" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='Bicicleta') ? 'selected' : ''; ?>>Bicicleta</option>
                                                            <option value="Patineta" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='Patineta') ? 'selected' : ''; ?>>Patineta</option>
                                                            <option value="Carro (propio)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='Carro (propio)') ? 'selected' : ''; ?>>Carro (propio)</option>
                                                            <option value="Moto (propio)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='Moto (propio)') ? 'selected' : ''; ?>>Moto (propio)</option>
                                                            <option value="Transporte público" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='Transporte público') ? 'selected' : ''; ?>>Transporte público</option>
                                                            <option value="Plataformas (picap,uber,cabify,Diddi)" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='Plataformas (picap,uber,cabify,Diddi)') ? 'selected' : ''; ?>>Plataformas (picap,uber,cabify,Diddi)</option>
                                                            <option value="No aplica" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_medio_transporte=='No aplica') ? 'selected' : ''; ?>>No aplica</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_interes_habitos_habito_ahorro" class="form-label my-0 font-size-12">¿Tienes el hábito de ahorrar?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_habito_ahorro" id="hvp_interes_habitos_habito_ahorro" data-container="body" title="Seleccione" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_habito_ahorro=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_habito_ahorro=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="hvp_interes_habitos_mascotas" class="form-label my-0 font-size-12">¿Tienes Mascotas?</label>
                                                        <select class="selectpicker form-control form-control-sm font-size-11 px-0 py-0" name="hvp_interes_habitos_mascotas" id="hvp_interes_habitos_mascotas" data-container="body" title="Seleccione" onchange="valida_mascota();" required>
                                                            <option value="Si" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_mascotas=='Si') ? 'selected' : ''; ?>>Si</option>
                                                            <option value="No" <?php echo ($data['resultado_registros_usuario'][0]->hvp_interes_habitos_mascotas=='No') ? 'selected' : ''; ?>>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3 d-none" id="div_hvp_interes_habitos_mascotas_cual">
                                                        <label for="hvp_interes_habitos_mascotas_cual" class="form-label my-0 font-size-12">Cuéntanos que mascota tienes?</label>
                                                        <input type="text" class="form-control form-control-sm font-size-11 px-2 py-1" name="hvp_interes_habitos_mascotas_cual" id="hvp_interes_habitos_mascotas_cual" value="<?php echo $data['resultado_registros_usuario'][0]->hvp_interes_habitos_mascotas_cual; ?>" required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo Flasher::flash(); ?>
                                            <div class="col-md-12 text-end">
                                                <span id="btn_enviar">
                                                    <a href="<?php echo URL; ?>hoja-vida/formulario-salud-bienestar/<?php echo base64_encode('salud-bienestar'); ?>" class="btn btn-warning login-btn">Regresar</a>
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
<?php require_once INCLUDES.'inc_footer.php'; ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#hvp_interes_habitos_hobbies_deportes_cual").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_interes_habitos_hobbies_aire_cual").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_interes_habitos_hobbies_arte_instrumento").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_interes_habitos_hobbies_arte_cual").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_interes_habitos_hobbies_tecnologia_cual").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_interes_habitos_hobbies_otro_cual").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
        });
    });

    jQuery(document).ready(function(){
        jQuery("#hvp_interes_habitos_mascotas_cual").on('input', function (evt) {
            jQuery(this).val(jQuery(this).val().toUpperCase());
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

    function valida_deporte() {
        $("#div_hvp_interes_habitos_actividades_deportivas_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_interes_habitos_actividades_deportivas_cual').disabled=true;

        var hvp_interes_habitos_actividades_deportivas = document.getElementById("hvp_interes_habitos_actividades_deportivas").value;

        if (hvp_interes_habitos_actividades_deportivas!="" && (hvp_interes_habitos_actividades_deportivas=="Si")) {
            $("#div_hvp_interes_habitos_actividades_deportivas_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_actividades_deportivas_cual').disabled=false;
        }
    }

    function valida_mascota() {
        $("#div_hvp_interes_habitos_mascotas_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_interes_habitos_mascotas_cual').disabled=true;

        var hvp_interes_habitos_mascotas = document.getElementById("hvp_interes_habitos_mascotas").value;

        if (hvp_interes_habitos_mascotas!="" && (hvp_interes_habitos_mascotas=="Si")) {
            $("#div_hvp_interes_habitos_mascotas_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_mascotas_cual').disabled=false;
        }
    }

    function valida_hdeportes() {
        $("#div_hvp_interes_habitos_hobbies_deportes_frecuencia").removeClass('d-block').addClass('d-none');
        $("#div_hvp_interes_habitos_hobbies_deportes_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_interes_habitos_hobbies_deportes_frecuencia').disabled=true;
        document.getElementById('hvp_interes_habitos_hobbies_deportes_cual').disabled=true;

        var hvp_interes_habitos_hobbies_deportes = document.getElementById("hvp_interes_habitos_hobbies_deportes");
        var hvp_interes_habitos_hobbies_deportes_array = Array.from(hvp_interes_habitos_hobbies_deportes.selectedOptions).map(option => option.value);
        
        if (hvp_interes_habitos_hobbies_deportes_array.length>0) {
            $("#div_hvp_interes_habitos_hobbies_deportes_frecuencia").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_deportes_frecuencia').disabled=false;
            $('#hvp_interes_habitos_hobbies_deportes_frecuencia').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_deportes_frecuencia').selectpicker();
        }

        if (hvp_interes_habitos_hobbies_deportes_array.includes("Otro")) {
            $("#div_hvp_interes_habitos_hobbies_deportes_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_deportes_cual').disabled=false;
        }

        if (hvp_interes_habitos_hobbies_deportes_array.length==2 && hvp_interes_habitos_hobbies_deportes_array.includes("Ninguno")) {
            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_deportes.options.length; i++) {
                if (hvp_interes_habitos_hobbies_deportes.options[i].value == "Ninguno") {
                    hvp_interes_habitos_hobbies_deportes.options[i].selected = false;
                }
            }

            $('#hvp_interes_habitos_hobbies_deportes').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_deportes').selectpicker();
        } else if (hvp_interes_habitos_hobbies_deportes_array.includes("Ninguno")) {
            $("#div_hvp_interes_habitos_hobbies_deportes_frecuencia").removeClass('d-block').addClass('d-none');
            $("#div_hvp_interes_habitos_hobbies_deportes_cual").removeClass('d-block').addClass('d-none');

            document.getElementById('hvp_interes_habitos_hobbies_deportes_frecuencia').disabled=true;
            document.getElementById('hvp_interes_habitos_hobbies_deportes_cual').disabled=true;

            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_deportes.options.length; i++) {
                if (hvp_interes_habitos_hobbies_deportes.options[i].value !== "Ninguno") {
                    hvp_interes_habitos_hobbies_deportes.options[i].selected = false;
                } else {
                    hvp_interes_habitos_hobbies_deportes.options[i].selected = true;
                }
            }

            $('#hvp_interes_habitos_hobbies_deportes').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_deportes').selectpicker();
        }
    }

    function valida_haire() {
        $("#div_hvp_interes_habitos_hobbies_aire_frecuencia").removeClass('d-block').addClass('d-none');
        $("#div_hvp_interes_habitos_hobbies_aire_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_interes_habitos_hobbies_aire_frecuencia').disabled=true;
        document.getElementById('hvp_interes_habitos_hobbies_aire_cual').disabled=true;

        var hvp_interes_habitos_hobbies_aire = document.getElementById("hvp_interes_habitos_hobbies_aire");
        var hvp_interes_habitos_hobbies_aire_array = Array.from(hvp_interes_habitos_hobbies_aire.selectedOptions).map(option => option.value);

        if (hvp_interes_habitos_hobbies_aire_array.length>0) {
            $("#div_hvp_interes_habitos_hobbies_aire_frecuencia").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_aire_frecuencia').disabled=false;
            $('#hvp_interes_habitos_hobbies_aire_frecuencia').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_aire_frecuencia').selectpicker();
        }

        if (hvp_interes_habitos_hobbies_aire_array.includes("Otro")) {
            $("#div_hvp_interes_habitos_hobbies_aire_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_aire_cual').disabled=false;
        }

        if (hvp_interes_habitos_hobbies_aire_array.length==2 && hvp_interes_habitos_hobbies_aire_array.includes("Ninguno")) {
            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_aire.options.length; i++) {
                if (hvp_interes_habitos_hobbies_aire.options[i].value == "Ninguno") {
                    hvp_interes_habitos_hobbies_aire.options[i].selected = false;
                }
            }

            $('#hvp_interes_habitos_hobbies_aire').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_aire').selectpicker();
        } else if (hvp_interes_habitos_hobbies_aire_array.includes("Ninguno")) {
            $("#div_hvp_interes_habitos_hobbies_aire_frecuencia").removeClass('d-block').addClass('d-none');
            $("#div_hvp_interes_habitos_hobbies_aire_cual").removeClass('d-block').addClass('d-none');

            document.getElementById('hvp_interes_habitos_hobbies_aire_frecuencia').disabled=true;
            document.getElementById('hvp_interes_habitos_hobbies_aire_cual').disabled=true;

            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_aire.options.length; i++) {
                if (hvp_interes_habitos_hobbies_aire.options[i].value !== "Ninguno") {
                    hvp_interes_habitos_hobbies_aire.options[i].selected = false;
                } else {
                    hvp_interes_habitos_hobbies_aire.options[i].selected = true;
                }
            }

            $('#hvp_interes_habitos_hobbies_aire').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_aire').selectpicker();
        }
    }

    function valida_harte() {
        $("#div_hvp_interes_habitos_hobbies_arte_frecuencia").removeClass('d-block').addClass('d-none');
        $("#div_hvp_interes_habitos_hobbies_arte_instrumento").removeClass('d-block').addClass('d-none');
        $("#div_hvp_interes_habitos_hobbies_arte_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_interes_habitos_hobbies_arte_frecuencia').disabled=true;
        document.getElementById('hvp_interes_habitos_hobbies_arte_instrumento').disabled=true;
        document.getElementById('hvp_interes_habitos_hobbies_arte_cual').disabled=true;

        var hvp_interes_habitos_hobbies_arte = document.getElementById("hvp_interes_habitos_hobbies_arte");
        var hvp_interes_habitos_hobbies_arte_array = Array.from(hvp_interes_habitos_hobbies_arte.selectedOptions).map(option => option.value);

        if (hvp_interes_habitos_hobbies_arte_array.length>0) {
            $("#div_hvp_interes_habitos_hobbies_arte_frecuencia").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_arte_frecuencia').disabled=false;
            $('#hvp_interes_habitos_hobbies_arte_frecuencia').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_arte_frecuencia').selectpicker();
        }

        if (hvp_interes_habitos_hobbies_arte_array.includes("Otro")) {
            $("#div_hvp_interes_habitos_hobbies_arte_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_arte_cual').disabled=false;
        }

        if (hvp_interes_habitos_hobbies_arte_array.includes("Música")) {
            $("#div_hvp_interes_habitos_hobbies_arte_instrumento").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_arte_instrumento').disabled=false;
        }

        if (hvp_interes_habitos_hobbies_arte_array.length==2 && hvp_interes_habitos_hobbies_arte_array.includes("Ninguno")) {
            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_arte.options.length; i++) {
                if (hvp_interes_habitos_hobbies_arte.options[i].value == "Ninguno") {
                    hvp_interes_habitos_hobbies_arte.options[i].selected = false;
                }
            }

            $('#hvp_interes_habitos_hobbies_arte').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_arte').selectpicker();
        } else if (hvp_interes_habitos_hobbies_arte_array.includes("Ninguno")) {
            $("#div_hvp_interes_habitos_hobbies_arte_frecuencia").removeClass('d-block').addClass('d-none');
            $("#div_hvp_interes_habitos_hobbies_arte_instrumento").removeClass('d-block').addClass('d-none');
            $("#div_hvp_interes_habitos_hobbies_arte_cual").removeClass('d-block').addClass('d-none');

            document.getElementById('hvp_interes_habitos_hobbies_arte_frecuencia').disabled=true;
            document.getElementById('hvp_interes_habitos_hobbies_arte_instrumento').disabled=true;
            document.getElementById('hvp_interes_habitos_hobbies_arte_cual').disabled=true;

            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_arte.options.length; i++) {
                if (hvp_interes_habitos_hobbies_arte.options[i].value !== "Ninguno") {
                    hvp_interes_habitos_hobbies_arte.options[i].selected = false;
                } else {
                    hvp_interes_habitos_hobbies_arte.options[i].selected = true;
                }
            }

            $('#hvp_interes_habitos_hobbies_arte').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_arte').selectpicker();
        }
    }

    function valida_htecnologia() {
        $("#div_hvp_interes_habitos_hobbies_tecnologia_frecuencia").removeClass('d-block').addClass('d-none');
        $("#div_hvp_interes_habitos_hobbies_tecnologia_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_interes_habitos_hobbies_tecnologia_frecuencia').disabled=true;
        document.getElementById('hvp_interes_habitos_hobbies_tecnologia_cual').disabled=true;

        var hvp_interes_habitos_hobbies_tecnologia = document.getElementById("hvp_interes_habitos_hobbies_tecnologia");
        var hvp_interes_habitos_hobbies_tecnologia_array = Array.from(hvp_interes_habitos_hobbies_tecnologia.selectedOptions).map(option => option.value);

        if (hvp_interes_habitos_hobbies_tecnologia_array.length>0) {
            $("#div_hvp_interes_habitos_hobbies_tecnologia_frecuencia").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_tecnologia_frecuencia').disabled=false;
            $('#hvp_interes_habitos_hobbies_tecnologia_frecuencia').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_tecnologia_frecuencia').selectpicker();
        }

        if (hvp_interes_habitos_hobbies_tecnologia_array.includes("Otro")) {
            $("#div_hvp_interes_habitos_hobbies_tecnologia_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_tecnologia_cual').disabled=false;
        }

        if (hvp_interes_habitos_hobbies_tecnologia_array.length==2 && hvp_interes_habitos_hobbies_tecnologia_array.includes("Ninguno")) {
            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_tecnologia.options.length; i++) {
                if (hvp_interes_habitos_hobbies_tecnologia.options[i].value == "Ninguno") {
                    hvp_interes_habitos_hobbies_tecnologia.options[i].selected = false;
                }
            }

            $('#hvp_interes_habitos_hobbies_tecnologia').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_tecnologia').selectpicker();
        } else if (hvp_interes_habitos_hobbies_tecnologia_array.includes("Ninguno")) {
            $("#div_hvp_interes_habitos_hobbies_tecnologia_frecuencia").removeClass('d-block').addClass('d-none');
            $("#div_hvp_interes_habitos_hobbies_tecnologia_cual").removeClass('d-block').addClass('d-none');

            document.getElementById('hvp_interes_habitos_hobbies_tecnologia_frecuencia').disabled=true;
            document.getElementById('hvp_interes_habitos_hobbies_tecnologia_cual').disabled=true;

            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_tecnologia.options.length; i++) {
                if (hvp_interes_habitos_hobbies_tecnologia.options[i].value !== "Ninguno") {
                    hvp_interes_habitos_hobbies_tecnologia.options[i].selected = false;
                } else {
                    hvp_interes_habitos_hobbies_tecnologia.options[i].selected = true;
                }
            }

            $('#hvp_interes_habitos_hobbies_tecnologia').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_tecnologia').selectpicker();
        }
    }

    function valida_hotros() {
        $("#div_hvp_interes_habitos_hobbies_otro_frecuencia").removeClass('d-block').addClass('d-none');
        $("#div_hvp_interes_habitos_hobbies_otro_cual").removeClass('d-block').addClass('d-none');

        document.getElementById('hvp_interes_habitos_hobbies_otro_frecuencia').disabled=true;
        document.getElementById('hvp_interes_habitos_hobbies_otro_cual').disabled=true;

        var hvp_interes_habitos_hobbies_otro = document.getElementById("hvp_interes_habitos_hobbies_otro");
        var hvp_interes_habitos_hobbies_otro_array = Array.from(hvp_interes_habitos_hobbies_otro.selectedOptions).map(option => option.value);

        if (hvp_interes_habitos_hobbies_otro_array.length>0) {
            $("#div_hvp_interes_habitos_hobbies_otro_frecuencia").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_otro_frecuencia').disabled=false;
            $('#hvp_interes_habitos_hobbies_otro_frecuencia').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_otro_frecuencia').selectpicker();
        }

        if (hvp_interes_habitos_hobbies_otro_array.includes("Otro")) {
            $("#div_hvp_interes_habitos_hobbies_otro_cual").removeClass('d-none').addClass('d-block');
            document.getElementById('hvp_interes_habitos_hobbies_otro_cual').disabled=false;
        }

        if (hvp_interes_habitos_hobbies_otro_array.length==2 && hvp_interes_habitos_hobbies_otro_array.includes("Ninguno")) {
            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_otro.options.length; i++) {
                if (hvp_interes_habitos_hobbies_otro.options[i].value == "Ninguno") {
                    hvp_interes_habitos_hobbies_otro.options[i].selected = false;
                }
            }

            $('#hvp_interes_habitos_hobbies_otro').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_otro').selectpicker();
        } else if (hvp_interes_habitos_hobbies_otro_array.includes("Ninguno")) {
            $("#div_hvp_interes_habitos_hobbies_otro_frecuencia").removeClass('d-block').addClass('d-none');
            $("#div_hvp_interes_habitos_hobbies_otro_cual").removeClass('d-block').addClass('d-none');

            document.getElementById('hvp_interes_habitos_hobbies_otro_frecuencia').disabled=true;
            document.getElementById('hvp_interes_habitos_hobbies_otro_cual').disabled=true;

            // Recorremos todas las opciones
            for (var i = 0; i < hvp_interes_habitos_hobbies_otro.options.length; i++) {
                if (hvp_interes_habitos_hobbies_otro.options[i].value !== "Ninguno") {
                    hvp_interes_habitos_hobbies_otro.options[i].selected = false;
                } else {
                    hvp_interes_habitos_hobbies_otro.options[i].selected = true;
                }
            }

            $('#hvp_interes_habitos_hobbies_otro').selectpicker('destroy');
            $('#hvp_interes_habitos_hobbies_otro').selectpicker();
        }
    }

    <?php if($data['resultado_registros_usuario'][0]->hvp_interes_habitos_hobbies_deportes!=''): ?>
        valida_deporte();
        valida_mascota();
        valida_hdeportes();
        valida_haire();
        valida_harte();
        valida_htecnologia();
        valida_hotros();
    <?php endif; ?>
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