<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class encuestasController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('encuestas/ver/0/null');
        }

        function configuracion($pagina, $filtro_busqueda, $bandeja) {
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            unset($_SESSION[APP_SESSION.'_encuestas_add']);
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            $modulo_perfil=$_SESSION[APP_SESSION.'usu_modulos']['Encuestas'];

            if(isset($_POST["form_filtro_busqueda"])){
                //obtiene variables de formulario
                $filtro_busqueda=checkInput($_POST['filtro_busqueda']);
                $pagina=0;
            }
            
            try {
                $registros = new encuestaModel();
                $registros->pagina = $pagina;
                $registros->limite = 20;
                $registros->offset = $pagina*$registros->limite;
                $registros->filtro = $filtro_busqueda;
                
                $array_estados=array();
                if ($bandeja=='Todos') {

                } elseif ($bandeja=='Pendientes') {
                    $array_estados[]='Pendiente';
                    $array_estados[]='Pendiente Fase 2';
                } elseif ($bandeja=='Diligenciados') {
                    $array_estados[]='Diligenciado';
                } elseif ($bandeja=='Documentos Cargados') {
                    $array_estados[]='Documentos Cargados';
                } elseif ($bandeja=='Finalizado') {
                    $array_estados[]='Rechazado';
                } elseif ($bandeja=='xxx') {
                    
                } elseif ($bandeja=='xxx') {
                    
                }

                $registros->filtro_bandeja = $array_estados;

                $res = $registros->list();
                $resCount = $registros->listCount();
                if (!isset($res[0])) {
                    $res=array();
                }
                if (!isset($resCount[0])) {
                    $resCount=array();
                }
                $pag_total=ceil(count($resCount)/$registros->limite);

                if (count($resCount)>0) {
                    $pag_inicio=($pagina*$registros->limite)+1;
                } else {
                    $pag_inicio=0;
                }
                
                if ((($pagina+1)*$registros->limite)>count($resCount)) {
                    $pag_fin=count($resCount);
                } else {
                    $pag_fin=(($pagina+1)*$registros->limite);
                }

                $data =
                [
                    'titulo_pagina' => 'ENCUESTAS|CONFIGURACIÓN|'.mb_strtoupper($bandeja),
                    'path' => 'encuestas/configuracion/',
                    'path_add' => '/'.base64_encode($bandeja),
                    'resultado_registros' => to_object($res),
                    'pag_inicio' => $pag_inicio,
                    'pag_fin' => $pag_fin,
                    'pag_total' => $pag_total,
                    'resultado_registros_count' => count($resCount),
                    'pagina' => $pagina,
                    'filtro' => $filtro_busqueda,
                    'bandeja' => base64_encode($bandeja),
                    'modulo_perfil' => $modulo_perfil,
                ];
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            
            View::render('configuracion', $data);
        }

        public static function configuracion_crear($pagina, $filtro_busqueda, $bandeja) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $area_lista = new areaModel();
            $resarea_lista = $area_lista->listActive();

            if (!isset($resarea_lista[0])) {
                $resarea_lista=array();
            }

            $cargo = new cargoModel();
            $rescargo=$cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $enc_estado=checkInput($_POST['enc_estado']);
                $enc_titulo=checkInput($_POST['enc_titulo']);
                $enc_descripcion=checkInput($_POST['enc_descripcion']);
 
                try {
                    if($_SESSION[APP_SESSION.'_encuestas_add']!=1) {
                        $encuestas = new encuestaModel();
                        $encuestas->enc_titulo=$enc_titulo;
                        $encuestas->enc_descripcion=$enc_descripcion;
                        $encuestas->enc_fecha_inicio='';
                        $encuestas->enc_fecha_fin='';
                        $encuestas->enc_estado=$enc_estado;
                        $encuestas->enc_areas='';
                        $encuestas->enc_contenido='';
                        $encuestas->enc_auxiliar_1='';
                        $encuestas->enc_auxiliar_2='';
                        $encuestas->enc_registro_usuario=checkInput($_SESSION[APP_SESSION.'usu_id']);
                        
                        $resinsert = $encuestas->add();

                        if ($resinsert) {
                            Flasher::new('¡Registro creado exitosamente!', 'success');
                            $_SESSION[APP_SESSION.'_encuestas_add']=1;
                        } else {
                            Flasher::new('¡Problemas al crear el registro, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Registro creado exitosamente!', 'success');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $data =
            [
                'titulo_pagina' => 'ENCUESTAS|CONFIGURACIÓN|CREAR',
                'path' => 'encuestas/configuracion-crear/',
                'path_add' => '/'.base64_encode($bandeja),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'bandeja' => base64_encode($bandeja),

            ];
            
            View::render('configuracion_crear', $data);
        }

        public static function configuracion_editar($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $modulo_plataforma=1;
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            
            $encuesta = new encuestaModel();
            $encuesta->enc_id=$id_registro;
            $resencuesta=$encuesta->listDetail();

            if (!isset($resencuesta[0])) {
                $resencuesta=array();
            }
            
            $area_lista = new areaModel();
            $resarea_lista = $area_lista->listActive();

            if (!isset($resarea_lista[0])) {
                $resarea_lista=array();
            }

            $cargo = new cargoModel();
            $rescargo=$cargo->listActive();

            if (!isset($rescargo[0])) {
                $rescargo=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $enc_estado=checkInput($_POST['enc_estado']);
                $enc_titulo=checkInput($_POST['enc_titulo']);
                $enc_descripcion=checkInput($_POST['enc_descripcion']);
                
                try {
                    $encuesta->enc_titulo=$enc_titulo;
                    $encuesta->enc_descripcion=$enc_descripcion;
                    $encuesta->enc_fecha_inicio='';
                    $encuesta->enc_fecha_fin='';
                    $encuesta->enc_estado=$enc_estado;
                    $encuesta->enc_areas='';
                    $encuesta->enc_contenido='';
                    $encuesta->enc_auxiliar_1='';
                    $encuesta->enc_auxiliar_2='';

                    $resupdate = $encuesta->update();
                    
                    if ($resupdate) {
                        Flasher::new('¡Registro editado exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $resencuesta=$encuesta->listDetail();

            if (!isset($resencuesta[0])) {
                $resencuesta=array();
            }

            $data =
            [
                'titulo_pagina' => 'ENCUESTAS|CONFIGURACIÓN|EDITAR',
                'path' => 'encuestas/configuracion-editar/',
                'path_add' => '/'.base64_encode($bandeja),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_area_lista' => to_object($resarea_lista),
                'resultado_registros_cargo' => to_object($rescargo),
                'resultado_registros' => to_object($resencuesta),
                'bandeja' => base64_encode($bandeja),
            ];
            
            View::render('configuracion_editar', $data);
        }

        public static function configuracion_preguntas($pagina, $filtro_busqueda, $bandeja, $id_registro) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $bandeja=checkInput(base64_decode($bandeja));
            $id_registro=checkInput(base64_decode($id_registro));
            // ini_set('display_errors', '1');
            // error_reporting(E_ALL);

            $encuesta = new encuestaModel();
            $encuesta->enc_id=$id_registro;
            $resencuesta=$encuesta->listDetail();

            if (!isset($resencuesta[0])) {
                $resencuesta=array();
            }
            
            $preguntas = new encuesta_preguntasModel();
            $preguntas->encp_encuesta=$id_registro;
            $respreguntas=$preguntas->list();

            if (!isset($respreguntas[0])) {
                $respreguntas=array();
            }

            $data =
            [
                'titulo_pagina' => 'ENCUESTAS|CONFIGURACIÓN|PREGUNTAS',
                'path' => 'encuestas/configuracion-preguntas/',
                'path_add' => '/'.base64_encode($bandeja),
                'resultado_registros' => to_object($resencuesta),
                'resultado_registros_preguntas' => to_object($respreguntas),
                'resultado_registros_preguntas_count' => count($respreguntas),
                'pag_inicio' => $pag_inicio,
                'pag_fin' => $pag_fin,
                'pag_total' => $pag_total,
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'bandeja' => base64_encode($bandeja),
                'id_registro' => base64_encode($id_registro),

            ];
            
            View::render('configuracion_preguntas', $data);
        }

        public static function configuracion_preguntas_crear($id_encuesta, $tipo, $accion, $id_pregunta) {
            Controller::checkSesion(); 
            $id_encuesta=checkInput(base64_decode($id_encuesta));
            $id_pregunta=checkInput(base64_decode($id_pregunta));
            $tipo=checkInput($tipo);
            $accion=checkInput($accion);
            
            if ($id_pregunta!=null AND $id_pregunta!='') {
                $preguntas = new encuesta_preguntasModel();
                $preguntas->encp_encuesta=$id_encuesta;
                $preguntas->encp_id=$id_pregunta;
                $respregunta=$preguntas->listDetail();
            }

            if (!isset($respregunta[0])) {
                $respregunta=array();
            }

            $array_tipo['opcion_multiple']='Opción múltiple/única respuesta';
            $array_tipo['verdadero_falso']='Verdadero/Falso';
            $array_tipo['abierta']='Respuesta abierta';
            $array_tipo['lista_desplegable']='Lista desplegable';
            
            $respregunta_opciones=explode(';', $respregunta[0]['encp_opciones']);

            $data =
            [
                'id_encuesta' => $id_encuesta,
                'id_pregunta' => $id_pregunta,
                'tipo' => $tipo,
                'accion' => $accion,
                'tipo_titulo' => $array_tipo[$tipo],
                'resultado_pregunta' => $respregunta,
                'resultado_pregunta_opciones' => $respregunta_opciones,
            ];
            
            View::render('configuracion_preguntas_crear', $data);
        }

        public static function configuracion_preguntas_accion() {
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            if(isset($_POST["id_encuesta"]) AND isset($_POST["tipo"]) AND isset($_POST["accion"])){
                $id_encuesta = checkInput($_POST["id_encuesta"]);
                $tipo = checkInput($_POST["tipo"]);
                $accion = checkInput($_POST["accion"]);
                $id_pregunta = checkInput($_POST["id_pregunta"]);
                
                $preguntas = new encuesta_preguntasModel();
                $preguntas->encp_encuesta = $id_encuesta;
                $preguntas->encp_id = $id_pregunta;
                
                $resconsecutivo=$preguntas->listMax();

                if (!isset($resconsecutivo[0])) {
                    $consecutivo=1;
                } else {
                    $consecutivo=intval($resconsecutivo[0]['maximo'])+1;
                }

                try {
                    //obtiene variables
                    $preguntas->encp_orden=$consecutivo;
                    $preguntas->encp_pregunta=checkInput($_POST['pregunta']);
                    $preguntas->encp_contenido='';
                    $preguntas->encp_tipo=checkInput($_POST['tipo']);

                    if ($preguntas->encp_tipo=='opcion_multiple' OR $preguntas->encp_tipo=='lista_desplegable') {
                        $preguntas->encp_opciones=implode(';', $_POST['opciones']);
                    } else {
                        $preguntas->encp_opciones='';
                    }
                    
                    $preguntas->encp_auxiliar_1='';
                    $preguntas->encp_auxiliar_2='';
                    $preguntas->encp_auxiliar_3='';
                    $preguntas->encp_auxiliar_4='';
                    $preguntas->encp_registro_usuario='1';
                    
                    if ($accion=='crear'){
                        $resinsert=$preguntas->add();
                        $resultado="<p class='alert alert-success p-1 text-center font-size-11'>¡Registro creado exitosamente!</p>";
                    } elseif ($accion=='editar'){
                        $preguntas->cp_id=$id_pregunta;
                        $resinsert=$preguntas->update();
                        $resultado="<p class='alert alert-success p-1 text-center font-size-11'>¡Registro actualizado exitosamente!</p>";
                    } elseif ($accion=='eliminar'){
                        $preguntas->cp_id=$id_pregunta;
                        $resinsert=$preguntas->delete();
                        $resultado="<p class='alert alert-success p-1 text-center font-size-11'>¡Registro eliminado exitosamente!</p>";
                    }
                    
                    if ($resinsert) {
                        $resultado_valor = 1;
                    } else {
                        $resultado_valor = 0;
                        $resultado="<p class='alert alert-warning p-1 text-center font-size-11'>¡Problemas al guardar el registro, por favor intente nuevamente!</p>";
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                $resultado_valor = 0;
                $resultado = '';
            }

            $data = array(
                "resultado" => $resultado,
                "resultado_valor" => $resultado_valor,
            );
            echo json_encode($data);
        }
    }