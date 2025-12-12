<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class administrador_cargosController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('administrador_cargos/ver/0/null');
        }

        function ver($pagina, $filtro_busqueda) {
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            unset($_SESSION[APP_SESSION.'_cargo_add']);

            if(isset($_POST["form_filtro_busqueda"])){
                //obtiene variables de formulario
                $filtro_busqueda=checkInput($_POST['filtro_busqueda']);
                $pagina=0;
            }
            
            try {
                $cargo = new cargoModel();
                $cargo->pagina = $pagina;
                $cargo->limite = 20;
                $cargo->offset = $pagina*$cargo->limite;
                $cargo->filtro = $filtro_busqueda;
                
                $res = $cargo->list();
                $resCount = $cargo->listCount();
                if (!isset($res[0])) {
                    $res=array();
                }
                if (!isset($resCount[0])) {
                    $resCount=array();
                }
                $pag_total=ceil(count($resCount)/$cargo->limite);

                if (count($resCount)>0) {
                    $pag_inicio=($pagina*$cargo->limite)+1;
                } else {
                    $pag_inicio=0;
                }
                
                if ((($pagina+1)*$cargo->limite)>count($resCount)) {
                    $pag_fin=count($resCount);
                } else {
                    $pag_fin=(($pagina+1)*$cargo->limite);
                }

                $data =
                [   
                    'titulo_pagina' => 'ADMNISTRADOR|CARGOS|VER',
                    'path' => 'administrador_cargos/ver/',
                    'resultado_registros' => to_object($res),
                    'pag_inicio' => $pag_inicio,
                    'pag_fin' => $pag_fin,
                    'pag_total' => $pag_total,
                    'resultado_registros_count' => count($resCount),
                    'pagina' => $pagina,
                    'filtro' => $filtro_busqueda,
                ];
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            
            View::render('ver', $data);
        }

        public static function crear($pagina, $filtro_busqueda) {
            $modulo_plataforma="1";
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            
            $formato = new calificacion_empleado_formatoModel();
            $resformato=$formato->listActive();

            if (!isset($resformato[0])) {
                $resformato=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $ac_codigo=checkInput($_POST['ac_codigo']);
                $ac_nombre=checkInput($_POST['ac_nombre']);
                $ac_formato_calificacion=checkInput($_POST['ac_formato_calificacion']);
                $ac_observaciones=checkInput($_POST['ac_observaciones']);

                try {
                    if($_SESSION[APP_SESSION.'_cargo_add']!=1) {
                        $cargo = new cargoModel();
                        $cargo->ac_codigo=$ac_codigo;
                        $cargo->ac_nombre=$ac_nombre;
                        $cargo->ac_formato_calificacion=$ac_formato_calificacion;
                        $cargo->ac_observaciones=$ac_observaciones;

                        $resinsert = $cargo->add();
                        
                        if ($resinsert) {
                            Flasher::new('¡Registro creado exitosamente!', 'success');
                            $_SESSION[APP_SESSION.'_cargo_add']=1;
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
                'titulo_pagina' => 'ADMNISTRADOR|CARGOS|CREAR',
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros_formato' => to_object($resformato),
            ];
            
            View::render('crear', $data);
        }

        public static function editar($pagina, $filtro_busqueda, $id_registro) {
            $modulo_plataforma=1;
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $id_registro=checkInput(base64_decode($id_registro));
            
            $cargo = new cargoModel();
            $cargo->ac_id = $id_registro;

            $formato = new calificacion_empleado_formatoModel();
            $resformato=$formato->listActive();

            if (!isset($resformato[0])) {
                $resformato=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $ac_codigo=checkInput($_POST['ac_codigo']);
                $ac_nombre=checkInput($_POST['ac_nombre']);
                $ac_formato_calificacion=checkInput($_POST['ac_formato_calificacion']);
                $ac_observaciones=checkInput($_POST['ac_observaciones']);
                
                try {
                    $cargo->ac_codigo=$ac_codigo;
                    $cargo->ac_nombre=$ac_nombre;
                    $cargo->ac_formato_calificacion=$ac_formato_calificacion;
                    $cargo->ac_observaciones=$ac_observaciones;

                    $resupdate = $cargo->update();
                    
                    if ($resupdate) {
                        Flasher::new('¡Registro editado exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $rescargo=$cargo->listDetail();

            $data =
            [
                'titulo_pagina' => 'ADMNISTRADOR|CARGOS|EDITAR',
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros' => to_object($rescargo),
                'resultado_registros_formato' => to_object($resformato),
            ];
            
            View::render('editar', $data);
        }
    }