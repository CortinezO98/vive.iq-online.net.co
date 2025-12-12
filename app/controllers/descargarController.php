<?php
    class descargarController extends Controller {
        function __construct()
        {
        }

        function formato($formato) {
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            Controller::checkSesion();
            
            try {
                $fileName = basename($formato);
                $filePath = ASSETS_ROOT."uploads/formatos/".$fileName;
                if(!empty($fileName) && file_exists($filePath)){
                    // Define headers
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=$fileName");
                    header("Content-Type: application/zip");
                    header("Content-Transfer-Encoding: binary");
                    
                    // Read the file
                    readfile($filePath);
                    exit;
                }else{
                    echo 'The file does not exist.';
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        function adjuntos($ruta, $fileName) {
            // error_reporting(E_ALL);
            // ini_set('display_errors', '1');
            Controller::checkSesion();

            $ruta=base64_decode($ruta);
            $fileName=base64_decode($fileName);
            $archivo_extension = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));
            $fileName=$fileName.'.'.$archivo_extension;

            try {
                $filePath = ASSETS_ROOT."uploads/".$ruta;
                if(!empty($filePath) && file_exists($filePath)){
                    // Define headers
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=$fileName");
                    header("Content-Type: application/zip");
                    header("Content-Transfer-Encoding: binary");
                    
                    // Read the file
                    readfile($filePath);
                    exit;
                }else{
                    echo 'The file does not exist.';
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }