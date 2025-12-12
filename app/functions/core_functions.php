<?php
    function to_object($array){
        return json_decode(json_encode($array));
    }

    function now(){
        return date('Y-m-d H:i:s');
    }

    function nowFile(){
        return date('Y_m_d_H_i_s');
    }

    /**
     * Validar input seguridad
     *
     * @param [type] $variable
     * @return void
     */
    function checkInput($input) {
        $input = trim($input); // Eliminar espacios al inicio y fin
        $input = strip_tags($input); // Eliminar etiquetas HTML
        $input = str_replace(["'", '"'], "", $input); // Eliminar comillas simples y dobles
        $input = str_replace(["=", ''], "", $input); // Eliminar =
        
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Codificar caracteres especiales para evitar XSS
    }

    function codigo($longitud=5){
        $alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_";
        $codigo = "";
        for($i=0;$i<$longitud;$i++){
          $codigo .= $alphabeth[rand(0,strlen($alphabeth)-1)];
        }

        return $codigo;
    }

    function pagTotal($conteo, $pagfinal){
        if ($pagfinal<$conteo) {
            return $pagfinal;
        } else {
            return $conteo;
        }
    }

    function iconoTipoContenido ($tipo) {
        if($tipo=="Pdf"){
            $icono_resultado="<span class='fas fa-file-pdf'></span>";
        } elseif($tipo=="Class Online"){
            $icono_resultado="<span class='fas fa-chalkboard-user'></span>";
        } elseif($tipo=="Presentación Interactiva"){
            $icono_resultado="<span class='fas fa-file-powerpoint'></span>";
        } elseif($tipo=="Games"){
            $icono_resultado="<span class='fas fa-gamepad'></span>";
        } elseif($tipo=="Infografía"){
            $icono_resultado="<span class='fas fa-timeline'></span>";
        } elseif($tipo=="Podcast"){
            $icono_resultado="<span class='fas fa-podcast'></span>";
        } elseif($tipo=="Trivias"){
            $icono_resultado="<span class='fas fa-list-check'></span>";
        } elseif($tipo=="Video url"){
            $icono_resultado="<span class='fa-brands fa-youtube'></span>";
        } elseif($tipo=="Video cargar"){
            $icono_resultado="<span class='fas fa-video'></span>";
        } elseif($tipo=="Cuestionario"){
            $icono_resultado="<span class='fas fa-list-check'></span>";
        }
  
        return $icono_resultado;
    }

    function iconoLog($tipo) {
        if ($tipo=="inicio_sesion"):
            $icono='<span class="fas fa-sign-in-alt"></span>';
        elseif ($tipo=="cierre_sesion"):
            $icono='<span class="fas fa-sign-out-alt"></span>';
        elseif($tipo=="crear_registro"):
            $icono='<span class="fas fa-plus-square"></span>';
        elseif($tipo=="crear_registro_error"):
            $icono='<span class="fas fa-plus-square"></span>';
        elseif($tipo=="crear_registro"):
            $icono='<span class="fas fa-plus-square"></span>';
        elseif($tipo=="editar_registro"):
            $icono='<span class="fas fa-edit"></span>';
        elseif($tipo=="editar_registro_error"):
            $icono='<span class="fas fa-edit"></span>';
        elseif($tipo=="eliminar_registro"):
            $icono='<span class="fas fa-trash-alt"></span>';
        elseif($tipo=="eliminar_registro_error"):
            $icono='<span class="fas fa-trash-alt"></span>';
        elseif($tipo=="notificacion_programada"):
            $icono='<span class="fas fa-envelope"></span>';
        elseif($tipo=="notificacion_programada_error"):
            $icono='<span class="fas fa-envelope"></span>';
        elseif($tipo=="token_sesion"):
            $icono='<span class="fas fa-qrcode"></span>';
        elseif($tipo=="token_sesion_error"):
            $icono='<span class="fas fa-qrcode"></span>';
        elseif($tipo=="login_bloqueado"):
            $icono='<span class="fas fa-user-lock"></span>';
        elseif($tipo=="login_bloqueado_error"):
            $icono='<span class="fas fa-user-lock"></span>';
        elseif($tipo=="password_update"):
            $icono='<span class="fas fa-key"></span>';
        elseif($tipo=="password_update_error"):
            $icono='<span class="fas fa-key"></span>';
        elseif($tipo=="password_register"):
            $icono='<span class="fas fa-key"></span>';
        elseif($tipo=="password_register_error"):
            $icono='<span class="fas fa-key"></span>';
        elseif($tipo=="password_expirada"):
            $icono='<span class="fas fa-key"></span>';
        elseif($tipo=="revision_documentos"):
                $icono='<span class="fas fa-key"></span>';
        else:
            $icono='';
        endif;
  
        return $icono;
      }

    
    
      function extensionTipoContenido ($tipo, $extension) {
        $extension_resultado = false;
        if($tipo=="Pdf"){
            $array_extensiones = ['pdf'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Soporte histórico"){
            $array_extensiones = ['xls', 'xlsx'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Class Online"){
            $array_extensiones = ['zip', 'rar'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Presentación Interactiva"){
            $array_extensiones = ['zip', 'rar'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Games"){
            $array_extensiones = ['zip', 'rar'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Infografía"){
            $array_extensiones = ['pdf', 'png', 'jpg', 'jpeg'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Podcast"){
            $array_extensiones = ['mp3'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Trivias"){
            $array_extensiones = ['zip', 'rar'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        } elseif($tipo=="Video url"){
            $extension_resultado = true;
        } elseif($tipo=="Video cargar"){
            $array_extensiones = ['avi', 'wmv', 'mov', 'mp4'];
            if (in_array($extension, $array_extensiones)) {
                $extension_resultado = true;
            }
        }
  
        return $extension_resultado;
    }

    function deleteDirectory($dir) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
            if($current != '.' && $current != '..') {
                if (!@unlink($dir.'/'.$current)) 
                    deleteDirectory($dir.'/'.$current);
            }       
        }
        closedir($dh);
        @rmdir($dir);
    }

    function notificacion_general($contenido, $boton_titulo, $boton_url) {
        // PROGRAMAR NOTIFICACIÓN CORREO
        /*SE ESTRUCTURA CONTENIDO DE CORREO*/
            $contenido_correo="<center><table style='width:100%; max-width: 600px; font-size: 13px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'><img src='cid:logo_notificacion' style='width: 600px;'></img></td>
                    </tr>
                </table>
                <table style='width:100%; max-width: 600px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'>
                            ".$contenido."
                            <br>
                            <br>
                            <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Cordialmente,<br><br><b>".APP_NAME_ALL."</b></p>
                        </td>
                    </tr>
                </table>
                <table style='width:100%; max-width: 600px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'>
                            <center>
                                <p style='font-size: 12px;font-family: Lato, Arial, sans-serif; color: #666666;'>Tenga en cuenta que este correo se genera de manera automática, por favor no lo responda ya que la solicitud no será redireccionada ni tramitada.
                                </p>
                            </center>
                        </td>
                    </tr>
                </table>
            </center>";
        /*SE ESTRUCTURA CONTENIDO DE CORREO*/
        return $contenido_correo;
    }

    function notificacion_credenciales($contenido, $boton_titulo, $boton_url) {
        // PROGRAMAR NOTIFICACIÓN CORREO
        /*SE ESTRUCTURA CONTENIDO DE CORREO*/
        $contenido_correo="<center><table style='width:100%; max-width: 600px; font-size: 13px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'><img src='cid:logo_notificacion' style='width: 300px;'></img></td>
                    </tr>
                </table>
                <table style='width:100%; max-width: 600px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'>
                            ".$contenido."
                            <br>
                            <br>
                            <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Cordialmente,<br><br><b>".APP_NAME_ALL."</b></p>
                        </td>
                    </tr>
                </table>
                <table style='width:100%; max-width: 600px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'>
                            <center>
                                <p style='font-size: 12px;font-family: Lato, Arial, sans-serif; color: #666666;'>Tenga en cuenta que este correo se genera de manera automática, por favor no lo responda ya que la solicitud no será redireccionada ni tramitada.
                                </p>
                            </center>
                        </td>
                    </tr>
                </table>
            </center>";
        /*SE ESTRUCTURA CONTENIDO DE CORREO*/
        return $contenido_correo;
    }

    function notificacion_buzon_digital($contenido, $boton_titulo, $boton_url, $tipo_solicitud) {
        // PROGRAMAR NOTIFICACIÓN CORREO
        /*SE ESTRUCTURA COTENIDO DE CORREO*/
            $contenido_correo="<center><table style='width:100%; max-width: 600px; font-size: 13px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'><center><img src='cid:logo_notificacion' style='width: 500px;'></img></center></td>
                    </tr>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'><p style='font-size: 12px;padding: 8px 5px 8px 5px; color: #666666; margin-top: 10px; text-align: center;'><b>Buzón Digital - ".$tipo_solicitud."</b></p></td>
                    </tr>
                </table>
                <table style='width:100%; max-width: 600px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'>
                            ".$contenido."
                            <br>
                            <br>
                            <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Cordialmente,<br><br><b>Buzón Digital<br>".APP_NAME_ALL."</br></p>
                        </td>
                    </tr>
                </table>
                <table style='width:100%; max-width: 600px; font-family: Lato, Arial, sans-serif;'>
                    <tr>
                        <td style='padding: 5px 5px 5px 5px;'>
                            <center>
                                <p style='font-size: 12px;font-family: Lato, Arial, sans-serif; color: #666666;'>Tenga en cuenta que este correo se genera de manera automática, por favor no lo responda ya que su solicitud no será redireccionada.
                                </p>
                            </center>
                        </td>
                    </tr>
                </table>
            </center>";
        /*SE ESTRUCTURA COTENIDO DE CORREO*/
        return $contenido_correo;
    }

    function checkFiles($path){
        $dir = opendir($path);
        $files = array();
        while ($current = readdir($dir)){
            if( $current != "." && $current != "..") {
                if(is_dir($path.$current)) {
                    checkFiles($path.$current.'/');
                }
                else {
                    $files[] = $current;
                }
            }
        }
        $control_ext=0;
        for($i=0; $i<count( $files ); $i++){
            if (!whiteListExt(strtolower(pathinfo($files[$i], PATHINFO_EXTENSION)))) {
                $control_ext++;
                echo strtolower(pathinfo($files[$i], PATHINFO_EXTENSION));
                echo "<br>";
            }
        }

        if ($control_ext>0) {
            return false;
        }

        return true;
    }

    function whiteListExt($extension){
        $allowed_extensions = ['xls', 'xlsx', 'pdf']; // Define las extensiones permitidas
        return in_array(strtolower($extension), $allowed_extensions);
    }

    function whiteListExtImage($extension){
        $allowed_extensions = ['png', 'jpg', 'jpeg']; // Define las extensiones permitidas
        return in_array(strtolower($extension), $allowed_extensions);
    }

    function whiteListMimeImage($mime_type){
        $allowed_mime_types  = ['image/png', 'image/jpg', 'image/jpeg']; // Define las extensiones permitidas
        return in_array(strtolower($mime_type), $allowed_mime_types );
    }

    function nombre_documento($tipo) {
        $nombre_documento['documento_identidad']='Documento de identificación';
        
        return $nombre_documento[$tipo];
    }