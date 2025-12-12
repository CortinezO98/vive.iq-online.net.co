<?php
    class parametrosController extends Controller {
        function __construct()
        {
        }

        function index() {
            Controller::checkSesion();
            Redirect::to('parametros/ver/0/null');
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
                    'path' => 'parametros/ver/',
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

            View::render('parametros', $data);
        }

        public static function editar($pagina, $filtro_busqueda, $id_registro) {
            Controller::checkSesion();
            $pagina=checkInput($pagina);
            $filtro_busqueda=checkInput($filtro_busqueda);
            $id_registro=checkInput(base64_decode($id_registro));
            $parametro = new parametroModel();
            $parametro->app_id = $id_registro;

            if(isset($_POST["form_guardar"])){
                //obtiene variables de formulario
                $app_titulo=checkInput($_POST['app_titulo']);
                $app_descripcion=checkInput($_POST['app_descripcion']);
                $app_link=checkInput($_POST['app_link']);
                
                try {
                    $archivo_extension = strtolower(pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION));
                    if ($_FILES['documento']['name']!="" AND whiteListExt($archivo_extension)) {
                        $array_extensiones=explode('.', strtolower($_FILES['documento']['name']));
                        array_push($array_extensiones, $archivo_extension);
                        $valida_ext=true;
                        $valida_extMime=true;
                        if (count($array_extensiones) < 2) {
                            for ($i=1; $i < count($array_extensiones); $i++) { 
                                $valida_ext=whiteListExtImage($array_extensiones[$i]);
                                if (!$valida_ext) {
                                    break;
                                }
                            }
                        } else {
                            $valida_ext=false;
                        }

                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                        $valida_extMime=whiteListMimeImage($finfo->file($_FILES['documento']['tmp_name']));
                        
                        if ($valida_ext AND $valida_extMime) {
                            $NombreArchivo=nowFile().".".$archivo_extension;
                            $ruta_actual=ASSETS_ROOT."images/app/";
                            $ruta_actual_guardar="app/";
                            $ruta_final=$ruta_actual.$NombreArchivo;
                            $ruta_final_guardar=$ruta_actual_guardar.$NombreArchivo;
                            if ($_FILES['documento']["error"] > 0) {
                                $control_documento=0;
                            } else {
                            /*ahora con la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
                                if (move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_final)) {
                                    $control_documento=1;
                                    $parametro->app_imagen = $ruta_final_guardar;
                                    $parametro->updateImagen();
                                } else {
                                    $control_documento=0;
                                }
                            }
                        }
                    } else {
                        $control_documento=1;
                        $valida_ext=true;
                        $valida_extMime=true;
                    }
                    
                    if ($control_documento==1 AND $valida_ext AND $valida_extMime) {
                        $parametro->app_titulo=$app_titulo;
                        $parametro->app_descripcion=$app_descripcion;
                        $parametro->app_link=$app_link;
                        
                        $resupdate = $parametro->update();

                        if ($resupdate) {
                            Flasher::new('¡Registro actualizado exitosamente!', 'success');
                        } else {
                            Flasher::new('¡Problemas al actualizar el registro, verifique e intente nuevamente!', 'warning');
                        }
                    } else {
                        Flasher::new('¡Problemas al actualizar el registro, verifique e intente nuevamente!', 'warning');
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

            $resparametro = $parametro->listDetail();

            $data =
            [
                'pagina' => $pagina,
                'filtro' => $filtro_busqueda,
                'resultado_registros' => to_object($resparametro),
            ];
            
            View::render('editar', $data);
        }
    }