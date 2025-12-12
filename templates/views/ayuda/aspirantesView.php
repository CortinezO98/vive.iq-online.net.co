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
                <div class="row">
                    <div class="offset-xxl-1 col-xxl-8 offset-xl-1 col-xl-7 col-md-12 col-sm-12 col-12">
                        <!-- Content -->
                        <div class="docs-content mx-xxl-9">
                            
                            <!-- Introducción -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="intro">
                                        <h1 class="mb-2">Módulo Aspirantes</h1>
                                        <p class="mb-6 lead text-muted">
                                            El módulo <b>Aspirantes</b> permite gestionar los procesos de selección de ingreso a la compañía y las distintas ofertas disponibles.
                                            Desde este módulo, los responsables del proceso de selección y las áreas involucradas pueden crear los aspirantes y enviar las ofertas a las distintas vacantes, recopilar y validar la información diligenciada por los aspirantes a través del formulario de hoja de vida y gestionar los distintos estados en cada una de las etapas del proceso de selección e ingreso.
                                        </p>
                                        <p class="mb-6 lead text-muted">
                                            A continuación, se describen las principales funcionalidades disponibles dentro del módulo aspirantes.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- aspirantes bandeja -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="aspirantes-bandeja">
                                        <h2 class="h3">Aspirantes - Bandeja</h2>
                                        <p class="my-1">
                                            Muestra el listado completo de aspirantes registrados. Desde aquí se pueden filtrar resultados según el estado del aspirante, 
                                            buscar por nombre, número de indentificación, correo, entre otros. y acceder a las opciones de edición de cada registro, detalle de ofertas o creación de nuevos aspirantes.
                                            <br>
                                            Desde esta bandeja también se puede acceder a las siguientes funcionalidades según el perfil del usuario que accede a la plataforma:
                                            <ul>
                                                <li><b>Crear Aspirante:</b> Permite registrar un nuevo aspirante de forma individual ingresando sus datos básicos y la oferta a la que se postula.</li>
                                                <li><b>Crear Aspirantes Masivo:</b> Permite registrar una base de aspirantes de forma masiva y el envío individual automático de la oferta asociada al proceso de selección.</li>
                                                <li><b>Actualizar Aspirantes Masivo:</b> Permite actualizar de forma masiva el estado de los aspirantes.</li>
                                                <li><b>Actualizar Correo Masivo:</b> Permite actualizar de forma masiva el correo electrónico corporativo de los aspirantes una vez se encuentran vinculados a la compañía.</li>
                                                <li><b>Reportes:</b> Permite generar reportes en formato de excel con toda la información del proceso de selección según el perfil del usuario que ingresa a la plataforma.</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/bandeja.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Crear aspirante -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="crear-aspirante">
                                        <h2 class="h3">Crear aspirante</h2>
                                        <p class="my-1">
                                            Permite registrar un nuevo aspirante y oferta en el sistema ingresando sus datos básicos, centro de costo, director, cargo al que aspira y psicólogo responsable del proceso.
                                            <br>
                                            En este proceso es importante tener en cuenta las siguientes consideraciones:
                                            <ul>
                                                <li>En caso de que el aspirante se encuentre registrado previamente en el sistema por un proceso de selección anterior, la plataforma valida con el número de identificación y actualiza los datos generando únicamente el registro de la nueva oferta para evitar duplicidad de aspirantes.</li>
                                                <li>Una vez creado (actualizado) el aspirante y la oferta, se enviará de forma automática un correo electrónico con la oferta y el enlace al formulario de hoja de vida para que el aspirante pueda diligenciar su información.</li>
                                                <li>Es importante asegurarse de que el correo electrónico ingresado sea correcto, ya que será el medio principal de comunicación entre la plataforma y el aspirante durante todo el proceso de selección.</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/crear_aspirante.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Crear aspirante masivo -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="crear-aspirante-masivo">
                                        <h2 class="h3">Crear aspirantes masivo</h2>
                                        <p class="my-1">
                                            Permite registrar múltiples aspirantes de forma simultánea a través de un archivo en formato Excel. 
                                            La plataforma valida automáticamente la información cargada en el Excel y envía las ofertas a cada aspirante de manera individual.
                                            <br>
                                            Consideraciones importantes:
                                            <ul>
                                                <li>En caso de que el aspirante se encuentre previamente en el sistema por un proceso de selección anterior, la plataforma valida con el número de identificación y actualiza los datos generando únicamente el registro de la nueva oferta para evitar duplicidad de aspirantes.</li>
                                                <li>Una vez creado (actualizado) el aspirante y la oferta, se enviará de forma automática un correo electrónico con la oferta y el enlace al formulario de hoja de vida para que el aspirante pueda diligenciar su información.</li>
                                                <li>El archivo de Excel debe cumplir con el formato y estructura especificada en la plantilla de carga.</li>
                                                <li>Se recomienda revisar los errores de revisión reportados para su respectiva corrección y nuevo cargue.</li>
                                            </ul>
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/crear_aspirante_masivo.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Editar aspirante -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="editar-aspirante">
                                        <h2 class="h3">Editar aspirante</h2>
                                        <p class="my-1">
                                            Desde esta pantalla se pueden modificar los datos básicos de un aspirante existente.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/editar_aspirante.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Parámetros bandeja -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="actualizar-correo-masivo">
                                        <h2 class="h3">Actualizar correos masivo</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede actualizar de forma masiva el correo corporativo de los aspirantes registrados en la plataforma a través de un archivo en formato Excel.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/actualizar_correo_masivo.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Parámetros bandeja -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="actualizar-estado-masivo">
                                        <h2 class="h3">Actualizar estado masivo</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede actualizar de forma masiva el estado de los aspirantes registrados en la plataforma a través de un archivo en formato Excel.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/actualizar_masivo_estado.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buzones Correo -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="ofertas">
                                        <h2 class="h3">Ofertas</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede ingresar al detalle del aspirante y de las ofertas enviadas, revisar el estado de las mismas, validar la información diligenciada y visualizar la documentación cargada.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/ofertas.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Revisar oferta -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="revisar-oferta">
                                        <h2 class="h3">Revisar oferta</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede administrar los estados de diligenciamiento y validación de las ofertas, definir la etapa del proceso.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/revisar_oferta.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reenviar oferta -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="reenviar-oferta">
                                        <h2 class="h3">Reenviar oferta</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede reenviar la oferta al aspirante en caso de que no haya recibido el correo inicial o requiera volver a diligenciar la información.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/reenviar_oferta.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documentos aspirante -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="documentos-aspirante">
                                        <h2 class="h3">Documentos aspirante</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede visualizar y descargar los documentos cargados por el aspirante durante el proceso de diligenciamiento de la oferta, así como también cargar documentos adicionales requeridos para el proceso de selección o descargar la hoja de vida de selección en formato PDF con toda la información diligenciada.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/documentos_aspirante.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cargar/actualizar documentos aspirante -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="cargar-documentos">
                                        <h2 class="h3">Cargar/actualizar documentos aspirante</h2>
                                        <p class="my-1">
                                            Desde esta opción se puede cargar documentos adicionales requeridos para el proceso de selección.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/cargar_documentos_aspirante.jpg" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reportes -->
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-8" id="reportes">
                                        <h2 class="h3">Reportes</h2>
                                        <p class="my-1">
                                            Permite generar reportes en formato de excel con toda la información del proceso de selección según el perfil del usuario que ingresa a la plataforma.
                                        </p>
                                        <div class="col-md-12 mb-4">
                                            <img src="<?php echo IMAGES; ?>documentacion/aspirantes/reportes.jpg" alt="Crear aspirante masivo" class="img-fluid">
                                        </div>
                                        <p class="my-1">
                                            Los reportes  habilitados para descarga en formato de Excel son los siguientes:
                                            <br><br>
                                        </p>
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        Consolidado
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <b>Perfil:</b> Administrador, Gestor, Usuario
                                                        <br><br>
                                                        Reporte consolidado con las siguientes secciones de información:
                                                        <br>
                                                        <ul>
                                                            <li>Estado</li>
                                                            <li>No Identificación</li>
                                                            <li>Fecha de Expedición</li>
                                                            <li>Primer Nombre</li>
                                                            <li>Segundo Nombre</li>
                                                            <li>Primero Apellido</li>
                                                            <li>Segundo Apellido</li>
                                                            <li>Dirección</li>
                                                            <li>Barrio</li>
                                                            <li>Ciudad</li>
                                                            <li>Departamento</li>
                                                            <li>Celular</li>
                                                            <li>Celular Alternativo</li>
                                                            <li>Email</li>
                                                            <li>Email Corporativo</li>
                                                            <li>Lugar de Nacimiento</li>
                                                            <li>Fecha Nacimiento</li>
                                                            <li>Edad</li>
                                                            <li>Estado Civil</li>
                                                            <li>Género</li>
                                                            <li>Grupo Sanguíneo</li>
                                                            <li>RH</li>
                                                            <li>Operador Internet</li>
                                                            <li>Información Emergencia-Nombres y Apellidos</li>
                                                            <li>Información Emergencia-Parentesco</li>
                                                            <li>Información Emergencia-Teléfono</li>
                                                            <li>¿Tiene usted familiares, conyugue y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente trabaje en IQ?</li>
                                                            <li>Nombres y Apellidos</li>
                                                            <li>Área</li>
                                                            <li>¿Ha trabajado anteriormente en IQ?</li>
                                                            <li>Motivo del retiro</li>
                                                            <li>Fecha de retiro</li>
                                                            <li>¿Ha presentado procesos de selección previamente en IQ?</li>
                                                            <li>Cargo</li>
                                                            <li>Fecha</li>
                                                            <li>¿Declara tener otro trabajo u ocupación simultánea?</li>
                                                            <li>Tipo de vinculación</li>
                                                            <li>Nombre de la empresa</li>
                                                            <li>Cargo</li>
                                                            <li>Ocupación o trabajo desempeñado</li>
                                                            <li>¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar a su trabajo actual?</li>
                                                            <li>Activos</li>
                                                            <li>Pasivos</li>
                                                            <li>Patrimonio</li>
                                                            <li>Ingresos mensuales</li>
                                                            <li>Egresos mensuales</li>
                                                            <li>Otros ingresos</li>
                                                            <li>Concepto de otros ingresos</li>
                                                            <li>¿Realiza Operaciones en Moneda Extranjera?</li>
                                                            <li>¿Maneja recursos públicos?</li>
                                                            <li>¿Goza de reconocimiento público general?</li>
                                                            <li>¿Ejerce algún grado de poder público?</li>
                                                            <li>¿Tiene usted algún familiar que cumpla con una característica anterior?</li>
                                                            <li>Si alguna de las respuestas anteriores es afirmativa, por favor especifique</li>
                                                            <li>EPS</li>
                                                            <li>Fondo de pensión</li>
                                                            <li>Fondo de cesantías</li>
                                                            <li>Fondo voluntario de pensión</li>
                                                            <li>Medicina prepagada</li>
                                                            <li>Empresa</li>
                                                            <li>Cargo</li>
                                                            <li>Fecha inicio</li>
                                                            <li>Fecha retiro</li>
                                                            <li>Ciudad</li>
                                                            <li>Jefe nombre</li>
                                                            <li>Jefe cargo</li>
                                                            <li>Teléfonos</li>
                                                            <li>Motivo retiro</li>
                                                            <li>Nivel</li>
                                                            <li>Establecimiento</li>
                                                            <li>Titulo</li>
                                                            <li>Ciudad</li>
                                                            <li>Fecha inicio</li>
                                                            <li>Fecha terminacion</li>
                                                            <li>Tarjeta profesional</li>
                                                            <li>Fecha Diligenciamiento</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Ofertas
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <b>Perfil:</b> Administrador, Gestor, Usuario
                                                        <br><br>
                                                        Reporte con los siguientes campos de información:
                                                        <br>
                                                        <ul>
                                                            <li>Estado</li>
                                                            <li>No Identificación</li>
                                                            <li>Primer Nombre</li>
                                                            <li>Segundo Nombre</li>
                                                            <li>Primero Apellido</li>
                                                            <li>Segundo Apellido</li>
                                                            <li>Dirección</li>
                                                            <li>Barrio</li>
                                                            <li>Ciudad</li>
                                                            <li>Departamento</li>
                                                            <li>Celular</li>
                                                            <li>Celular Alternativo</li>
                                                            <li>Email</li>
                                                            <li>Lugar de Nacimiento</li>
                                                            <li>Fecha Nacimiento</li>
                                                            <li>Edad</li>
                                                            <li>Estado Civil</li>
                                                            <li>Género</li>
                                                            <li>Área</li>
                                                            <li>Cargo</li>
                                                            <li>Director</li>
                                                            <li>Psicólogo</li>
                                                            <li>Horario</li>
                                                            <li>Debida Diligencia</li>
                                                            <li>Prueba Confiabilidad</li>
                                                            <li>Exámen Médico</li>
                                                            <li>Check Contratación</li>
                                                            <li>Fecha Diligencia</li>
                                                            <li>Estado Oferta</li>
                                                            <li>Estado Oferta Fase 2</li>
                                                            <li>Fecha Registro Oferta</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Correos Gestión Usuarios
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <b>Perfil:</b> Administrador, Gestión Usuarios
                                                        <br><br>
                                                        Reporte con los siguientes campos de información:
                                                        <br>
                                                        <ul>
                                                            <li>Estado</li>
                                                            <li>No Identificación</li>
                                                            <li>Primer Nombre</li>
                                                            <li>Segundo Nombre</li>
                                                            <li>Primero Apellido</li>
                                                            <li>Segundo Apellido</li>
                                                            <li>Correo Corporativo</li>
                                                            <li>Fecha Ingreso</li>
                                                            <li>Ciudad de residencia</li>
                                                            <li>Centro de Costo</li>
                                                            <li>Cargo</li>
                                                            <li>NT</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFour">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                        Contratación
                                                    </button>
                                                </h2>
                                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <b>Perfil:</b> Administrador, Contratación
                                                        <br><br>
                                                        Reporte con los siguientes campos de información:
                                                        <br>
                                                        <ul>
                                                            <li>Tipo de documento de identidad</li>
                                                            <li>No Identificación</li>
                                                            <li>Fecha de Expedición</li>
                                                            <li>Primer Nombre</li>
                                                            <li>Segundo Nombre</li>
                                                            <li>Primero Apellido</li>
                                                            <li>Segundo Apellido</li>
                                                            <li>Género</li>
                                                            <li>Estado Civil</li>
                                                            <li>Lugar de Nacimiento</li>
                                                            <li>Fecha Nacimiento</li>
                                                            <li>Ciudad de residencia</li>
                                                            <li>Dirección de residencia</li>
                                                            <li>Barrio</li>
                                                            <li>Celular</li>
                                                            <li>Celular Alternativo</li>
                                                            <li>Email</li>
                                                            <li>Email Corporativo</li>
                                                            <li>Grupo Sanguíneo</li>
                                                            <li>RH</li>
                                                            <li>Fecha Ingreso</li>
                                                            <li>EPS</li>
                                                            <li>Fondo de pensión</li>
                                                            <li>Fondo de cesantías</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFive">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                        Cumplimiento
                                                    </button>
                                                </h2>
                                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <b>Perfil:</b> Administrador, Cumplimiento
                                                        <br><br>
                                                        Reporte con los siguientes campos de información:
                                                        <br>
                                                        <ul>
                                                            <li>Tipo de Identificación</li>
                                                            <li>No Identificación</li>
                                                            <li>Fecha de Expedición</li>
                                                            <li>Primer Nombre</li>
                                                            <li>Segundo Nombre</li>
                                                            <li>Primero Apellido</li>
                                                            <li>Segundo Apellido</li>
                                                            <li>Dirección</li>
                                                            <li>Barrio</li>
                                                            <li>Ciudad</li>
                                                            <li>Departamento</li>
                                                            <li>¿Tiene usted familiares, conyugue y/o compañero permanente, parientes dentro del cuarto grado de consanguinidad, tercero de afinidad o único civil que actualmente trabaje en IQ?</li>
                                                            <li>Nombres y Apellidos</li>
                                                            <li>Área</li>
                                                            <li>¿Declara tener otro trabajo u ocupación simultánea?</li>
                                                            <li>Tipo de vinculación</li>
                                                            <li>Nombre de la empresa</li>
                                                            <li>Cargo</li>
                                                            <li>Ocupación o trabajo desempeñado</li>
                                                            <li>¿Si su ocupación actual genera conflicto de interés, estaría dispuesto a renunciar a su trabajo actual?</li>
                                                            <li>Activos</li>
                                                            <li>Pasivos</li>
                                                            <li>Patrimonio</li>
                                                            <li>Ingresos mensuales</li>
                                                            <li>Egresos mensuales</li>
                                                            <li>Otros ingresos</li>
                                                            <li>Concepto de otros ingresos</li>
                                                            <li>¿Realiza Operaciones en Moneda Extranjera?</li>
                                                            <li>¿Maneja recursos públicos?</li>
                                                            <li>¿Goza de reconocimiento público general?</li>
                                                            <li>¿Ejerce algún grado de poder público?</li>
                                                            <li>¿Tiene usted algún familiar que cumpla con una característica anterior?</li>
                                                            <li>Si alguna de las respuestas anteriores es afirmativa, por favor especifique</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 d-none d-xl-block position-fixed end-0">
                        <div class="sidebar-nav-fixed">
                            <span class="px-4 mb-2 d-block text-uppercase ls-md h4 fs-6">Contenido</span>
                            <ul class="list-unstyled">
                                <li><a href="#intro" class="active">Introducción</a></li>
                                <li><a href="#aspirantes-bandeja">Aspirantes - Bandeja</a></li>
                                <li><a href="#crear-aspirante">Crear aspirante</a></li>
                                <li><a href="#crear-aspirante-masivo">Crear aspirantes masivo</a></li>
                                <li><a href="#editar-aspirante">Editar aspirante</a></li>
                                <li><a href="#actualizar-correo-masivo">Actualizar correos masivo</a></li>
                                <li><a href="#actualizar-estado-masivo">Actualizar estado masivo</a></li>
                                <li><a href="#ofertas">Ofertas</a></li>
                                <li><a href="#revisar-oferta">Revisar oferta</a></li>
                                <li><a href="#reenviar-oferta">Reenviar oferta</a></li>
                                <li><a href="#documentos-aspirante">Documentos aspirante</a></li>
                                <li><a href="#cargar-documentos">Cargar/actualizar documentos aspirante</a></li>
                                <li><a href="#reportes">Reportes</a></li>
                            </ul>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once INCLUDES.'inc_footer.php'; ?>