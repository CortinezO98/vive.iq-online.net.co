<?php
    class administrador_parametrosController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('administrador-parametros/ver/0/null');
        }

        function ver($pagina, $filtro_busqueda) {
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            unset($_SESSION[APP_SESSION.'_area_add']);
            unset($_SESSION[APP_SESSION.'_area_delete']);

            if(isset($_POST["form_filtro_busqueda"])){
                //obtiene variables de formulario
                $filtro_busqueda=checkInput($_POST['filtro_busqueda']);
                $pagina=0;
            }
            
            try {
                $parametro = new parametroModel();
                $parametro->pagina = $pagina;
                $parametro->limite = 20;
                $parametro->offset = $pagina*$parametro->limite;
                $parametro->filtro = $filtro_busqueda;
                
                $res = $parametro->list();
                $resCount = $parametro->listCount();
                if (!isset($res[0])) {
                    $res=array();
                }
                if (!isset($resCount[0])) {
                    $resCount=array();
                }
                $pag_total=ceil(count($resCount)/$parametro->limite);

                if (count($resCount)>0) {
                    $pag_inicio=($pagina*$parametro->limite)+1;
                } else {
                    $pag_inicio=0;
                } 
                
                if ((($pagina+1)*$parametro->limite)>count($resCount)) {
                    $pag_fin=count($resCount);
                } else {
                    $pag_fin=(($pagina+1)*$parametro->limite);
                }

                $data =
                [
                    'titulo_pagina' => 'ADMINISTRADOR|PARÁMETROS',
                    'path' => 'administrador-parametros/ver/',
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

        public static function editar($pagina, $filtro_busqueda, $id_registro) {
            $modulo_plataforma=1;
            Controller::checkSesion();
            // error_reporting(E_ALL);
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $id_registro=checkInput(base64_decode($id_registro));
            
            $registro = new parametroModel();
            $registro->app_id = $id_registro;
            $resregistro=$registro->listDetail();

            if (!isset($resregistro[0])) {
                $resregistro=array();
            }

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                if ($resregistro[0]['app_tipo']=='lista') {
                    $app_descripcion=implode(';', $_POST['opciones']);
                } else {
                    $app_descripcion=$_POST['app_descripcion'];
                }
                
                try {
                    $registro->app_descripcion=$app_descripcion;

                    $resupdate = $registro->update();
                    
                    if ($resupdate) {
                        Flasher::new('¡Registro editado exitosamente!', 'success');
                    } else {
                        Flasher::new('¡Problemas al editar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $resregistro=$registro->listDetail();
            $array_listas=array();
            if ($resregistro[0]['app_tipo']=='lista') {
                $array_listas=explode(';', $resregistro[0]['app_descripcion']);
            }

            $data =
            [
                'titulo_pagina' => 'ADMINISTRADOR|PARÁMETROS|EDITAR',
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'array_listas' => $array_listas,
                'resultado_registros' => to_object($resregistro),
            ];
            
            View::render('editar', $data);
        }
    }