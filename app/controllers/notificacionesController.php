<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require_once '/var/www/vive.iq-online.net.co/app/config/config.php';
    require_once '/var/www/vive.iq-online.net.co/app/functions/core_functions.php';
    require_once '/var/www/vive.iq-online.net.co/app/classes/Db.php';
    require_once '/var/www/vive.iq-online.net.co/app/classes/Model.php';
    require_once '/var/www/vive.iq-online.net.co/app/models/notificacionModel.php';
    
    require MAILER_ROOT.'vendor/autoload.php';

    $notificacion = new notificacionModel();
    $notificacion->nc_estado_envio = 'Pendiente';
    $notificacion->nc_id_set_from = '1';
    $notificacion->offset = '0';
    $notificacion->limite = '20';
    $notificacion->nc_prioridad='Horario';
    
    if (intval(date('H'))>=8 AND intval(date('H'))<17 AND intval(date('w'))>0  AND intval(date('w'))<6) {
        $resnotificaciones = $notificacion->listPendiente();
    } else {
        $resnotificaciones = $notificacion->listPendienteHorario();
    }
    
    if (!isset($resnotificaciones[0])) {
        $resnotificaciones=array();
    }
    if (count($resnotificaciones)>0) {
        for ($i=0; $i < count($resnotificaciones); $i++) {
            $notificacion->nc_id = $resnotificaciones[$i]['nc_id'];
            $notificacion->nc_fecha_envio = now();
            
            if ($resnotificaciones[$i]['ncr_host']!="" AND $resnotificaciones[$i]['ncr_port']!="" AND $resnotificaciones[$i]['ncr_smtpsecure']!="" 
                AND $resnotificaciones[$i]['ncr_smtpauth']!="" AND $resnotificaciones[$i]['ncr_username']!="" AND $resnotificaciones[$i]['ncr_password']!="" 
                AND $resnotificaciones[$i]['ncr_setfrom']!="" AND $resnotificaciones[$i]['ncr_setfrom_name']!="" AND ($resnotificaciones[$i]['nc_address']!="" OR $resnotificaciones[$i]['nc_bcc']!="") 
                AND $resnotificaciones[$i]['nc_subject']!="" AND $resnotificaciones[$i]['nc_body']!="") {

                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = $resnotificaciones[$i]['ncr_host'];
                    $mail->Port = $resnotificaciones[$i]['ncr_port'];
                    $mail->SMTPSecure = $resnotificaciones[$i]['ncr_smtpsecure'];
                    $mail->SMTPAuth = $resnotificaciones[$i]['ncr_smtpauth'];
                    $mail->SMTPDebug  = 0;
                    $mail->Username = $resnotificaciones[$i]['ncr_username'];
                    $mail->Password = $resnotificaciones[$i]['ncr_password'];
                    $mail->SetFrom($resnotificaciones[$i]['ncr_setfrom'], $resnotificaciones[$i]['ncr_setfrom']);
                    
                    $num_intentos=intval($resnotificaciones[$i]['nc_intentos'])+1;

                    $notificacion->nc_intentos = $num_intentos;

                    if ($num_intentos>=2) {
                        $notificacion->nc_estado_envio = "Error";
                    } else {
                        $notificacion->nc_estado_envio = "Pendiente";
                    }

                    $destino_to=explode(";", $resnotificaciones[$i]['nc_address']);
                    for ($j=0; $j < count($destino_to); $j++) { 
                        if ($destino_to[$j]!="") {
                            $mail->addAddress($destino_to[$j], $destino_to[$j]);
                        }
                    }

                    $destino_cc=explode(";", $resnotificaciones[$i]['nc_cc']);
                    for ($j=0; $j < count($destino_cc); $j++) { 
                        if ($destino_cc[$j]!="") {
                            $mail->addCC($destino_cc[$j], $destino_cc[$j]);
                        }
                    }

                    $destino_bcc=explode(";", $resnotificaciones[$i]['nc_bcc']);
                    for ($j=0; $j < count($destino_bcc); $j++) { 
                        if ($destino_bcc[$j]!="") {
                            $mail->addBCC($destino_bcc[$j], $destino_bcc[$j]);
                        }
                    }

                    //embeddedimage
                    $image_embedded_ruta=explode(";", $resnotificaciones[$i]['nc_embeddedimage_ruta']);
                    $image_embedded_nombre=explode(";", $resnotificaciones[$i]['nc_embeddedimage_nombre']);
                    $image_embedded_tipo=explode(";", $resnotificaciones[$i]['nc_embeddedimage_tipo']);
                    for ($j=0; $j < count($image_embedded_ruta); $j++) { 
                        if ($image_embedded_ruta[$j]!="" AND $image_embedded_nombre[$j]!="" AND $image_embedded_tipo[$j]!="") {
                            $mail->AddEmbeddedImage($image_embedded_ruta[$j], $image_embedded_nombre[$j], $image_embedded_ruta[$j], 'base64', $image_embedded_tipo[$j]);
                        }
                    }

                    $nc_attachment_ruta=explode(";", $resnotificaciones[$i]['nc_attachment_ruta']);
                    for ($j=0; $j < count($nc_attachment_ruta); $j++) { 
                        if ($nc_attachment_ruta[$j]!="") {
                            $attachment_final=explode('|', $nc_attachment_ruta[$j]);

                            $mail->AddAttachment($attachment_final[0], $attachment_final[1]);
                        }
                    }
                    
                    $mail->IsHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = $resnotificaciones[$i]['nc_subject'];
                    $mail->Body    = $resnotificaciones[$i]['nc_body'];
                    if($mail->send()) {
                        $notificacion->nc_estado_envio = 'Enviado';
                        $notificacion->updateEstado();

                        // $consulta_notificaciones_update = mysqli_query($enlace_db, "UPDATE `administrador_notificaciones` SET `nc_estado_envio`='Enviado', `nc_fecha_envio`='".$marca_temporal."', `nc_intentos`='".$num_intentos."' WHERE `nc_id`='".$id_correo."'");
                    } else {
                        $notificacion->nc_estado_envio = 'Error';
                        $notificacion->updateEstado();
                        // $consulta_notificaciones_update = mysqli_query($enlace_db, "UPDATE `administrador_notificaciones` SET `nc_estado_envio`='".$estado_error."', `nc_fecha_envio`='".$marca_temporal."', `nc_intentos`='".$num_intentos."' WHERE `nc_id`='".$id_correo."'");
                    }
                    echo $notificacion->nc_estado_envio;
                }  catch (Exception $e) {
                    $reporte_error="";
                    $estado_error_final="";
                    echo $reporte_error=$e->getMessage(); // error messages from anything else!
                    //Validación excepciones
                    settype($reporte_error, 'string');
                    if (stristr($reporte_error, 'Invalid address:')) {
                        $estado_error_final='Destinatario inválido';
                    } elseif ($reporte_error=='SMTP Error: Could not authenticate.') {
                        $estado_error_final='Error de autenticación';
                    } elseif ($reporte_error=='You must provide at least one recipient email address.') {
                        $estado_error_final='Sin destinatario';
                    }

                    echo $estado_error_final;
                    if ($estado_error_final!="") {
                        $notificacion->nc_estado_envio = $estado_error_final;
                        $notificacion->updateEstado();
                        // $consulta_notificaciones_update = mysqli_query($enlace_db, "UPDATE `administrador_notificaciones` SET `nc_estado_envio`='".$estado_error_final."', `nc_fecha_envio`='".$marca_temporal."', `nc_intentos`='".$num_intentos."' WHERE `nc_id`='".$id_correo."'");
                    }
                }
            } else {
                echo "<br>eror esctructura";
                $notificacion->nc_estado_envio = 'Error-estructura';
                $notificacion->updateEstado();
                // $consulta_notificaciones_update = mysqli_query($enlace_db, "UPDATE `administrador_notificaciones` SET `nc_estado_envio`='Error-estructura', `nc_fecha_envio`='".$marca_temporal."', `nc_intentos`='1' WHERE `nc_id`='".$id_correo."'");
            }
        }
    }