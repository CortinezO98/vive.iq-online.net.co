<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require_once '/var/www/vive.iq-online.net.co/app/config/config.php';
    require_once '/var/www/vive.iq-online.net.co/app/functions/core_functions.php';
    require_once '/var/www/vive.iq-online.net.co/app/classes/Db.php';
    require_once '/var/www/vive.iq-online.net.co/app/classes/Model.php';
    require_once '/var/www/vive.iq-online.net.co/app/models/hv_personalModel.php';
    require_once '/var/www/vive.iq-online.net.co/app/models/notificacionModel.php';
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    require MAILER_ROOT.'vendor/autoload.php';

    $registros_hv = new hv_personalModel();
    $registros_hv->hvp_estado = 'Activo';
    $resregistros_hv = $registros_hv->listPendienteDiligenciamiento();
    
    
    if (!isset($resregistros_hv[0])) {
        $resregistros_hv=array();
    }
    if (count($resregistros_hv)>0) {
        $notificacion = new notificacionModel();
                            
        $boton_url=URL;
        $boton_titulo='Da clic aquí para ingresar';
        //PROGRAMACIÓN NOTIFICACIÓN 
            $contenido="<p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>¡Hola!</p>
            <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Recuerda que ya eres un ciudadano iQ</p>
            <p style='font-size: 12px;padding: 0px 5px 0px 5px; color: #666666;'>Te estamos esperando en Vive iQ, nuestra plataforma corporativa. Donde deberás tener al día tu información sociodemográfica.</p>
            <center>
                
                <br>
                <br>
                <a href='".$boton_url."' target='_blank' style='border-radius:4px; color:#ffffff; font-size:12px; padding: 5px 5px 5px 5px; text-align:center; text-decoration:none !important; width:50%; display: block; background-color: ".COLOR_PRINCIPAL."'>".$boton_titulo."</a>
            </center>";
        for ($i=0; $i < count($resregistros_hv); $i++) {
            $correo_corporativo=$resregistros_hv[$i]['hvp_contacto_correo_corporativo'];
            /*SE CONFIGURAN PARÁMETROS A REGISTRAR EN SISTEMA DE NOTIFICACIÓN*/
            $notificacion->nc_id_modulo='8';
            $notificacion->nc_prioridad='Baja';
            $notificacion->nc_estado_envio='Pendiente';
            $notificacion->nc_address=$correo_corporativo.';';
            $notificacion->nc_subject="Recordatorio | Bienvenido a Vive iQ";
            $notificacion->nc_body=notificacion_general($contenido, $boton_titulo, $boton_url);
            $notificacion->nc_embeddedimage_ruta="".BASEPATH_IMAGE."/logo/firma-verde.png;".BASEPATH_IMAGE."/logo/logo_notificacion_bienvenida.jpg";
            $notificacion->nc_embeddedimage_nombre="firma-verde;logo_notificacion";
            $notificacion->nc_embeddedimage_tipo="image/png;image/png";
            $notificacion->nc_usuario_registro='1';
            $resnotificacion=$notificacion->add();
            
            
        }
    }