<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class administrador_notificacionesController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('administrador_notificaciones/ver/0/null');
        }

        function ver($pagina, $filtro_busqueda) {
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);

            if(isset($_POST["form_filtro_busqueda"])){
                //obtiene variables de formulario
                $filtro_busqueda=checkInput($_POST['filtro_busqueda']);
                $pagina=0;
            }
            
            try {
                $registros = new notificacionModel();
                $registros->pagina = $pagina;
                $registros->limite = 20;
                $registros->offset = $pagina*$registros->limite;
                $registros->filtro = $filtro_busqueda;
                
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
                    'titulo_pagina' => 'ADMINISTRADOR|NOTIFICACIONES|VER',
                    'path' => 'administrador_notificaciones/ver/',
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
    }