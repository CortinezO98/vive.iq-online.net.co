<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;
    class administrador_buzonesController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('administrador-buzones/ver/0/null');
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
                $registros = new buzonesModel();
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
                    'titulo_pagina' => 'ADMNISTRADOR|BUZONES|VER',
                    'path' => 'administrador-buzones/ver/',
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
            
            $registro = new buzonesModel();
            $registro->ncr_id = $id_registro;

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $ncr_host=checkInput($_POST['ncr_host']);
                $ncr_port=checkInput($_POST['ncr_port']);
                $ncr_smtpsecure=checkInput($_POST['ncr_smtpsecure']);
                $ncr_smtpauth=checkInput($_POST['ncr_smtpauth']);
                $ncr_username=checkInput($_POST['ncr_username']);
                $ncr_password=checkInput($_POST['ncr_password']);
                $ncr_setfrom=checkInput($_POST['ncr_setfrom']);
                $ncr_setfrom_name=checkInput($_POST['ncr_setfrom_name']);
                
                try {
                    $registro->ncr_host=$ncr_host;
                    $registro->ncr_port=$ncr_port;
                    $registro->ncr_smtpsecure=$ncr_smtpsecure;
                    $registro->ncr_smtpauth=$ncr_smtpauth;
                    $registro->ncr_username=$ncr_username;
                    $registro->ncr_password=$ncr_password;
                    $registro->ncr_setfrom=$ncr_setfrom;
                    $registro->ncr_setfrom_name=$ncr_setfrom_name;

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

            $rescargo=$registro->listDetail();

            $data =
            [
                'titulo_pagina' => 'ADMNISTRADOR|BUZONES|EDITAR',
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros' => to_object($rescargo),
            ];
            
            View::render('editar', $data);
        }
    }