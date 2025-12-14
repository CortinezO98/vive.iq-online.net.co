<?php
    //Saber si estamos trabajando de forma local o remota
    define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));
    define('MANTENIMIENTO', '0');

    //Definir la zona horaria del sistema
    date_default_timezone_set('America/Bogota');
    
    //Definir lenguaje
    define('LANG', 'es');

    //Definir COLORES
    define('COLOR_PRINCIPAL', '#1C2262');
    define('COLOR_SECUNDARIO', '#09A28E');
    define('LOGO', 'logo/logo.png?v=1');
    define('LOGO_MENU', 'logo/logo.png?v=1');
    define('LOGO_NOTIFICACION', 'logo/logo_notificacion.png');
    
    //Definir Variables App
    define('APP_SESSION', 'viveiq');
    define('APP_NAME', 'Vive iQ');
    define('APP_NAME_ALL', 'Vive iQ - iQ Outsourcing');
    define('CLIENT_NAME', 'iQ Outsourcing');
    
    //Ruta base del proyecto
    define('BASEPATH', IS_LOCAL ? '/vive.iq-online.net.co/' : '');


    //Sal del sistema
    define('AUTH_SALT', 'WebDeveloper2023!');

    //Puerto y url del sitio
    define('PORT', '8012');
    define('URL', IS_LOCAL ? 'http://localhost:8012'.BASEPATH : 'https://vive.iq-online.net.co/');


    //Rutas de directorios y archivos
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', getcwd().DS);
    
    if (IS_LOCAL) {
        define('BASEPATH_IMAGE', 'C:\xampp\htdocs\vive.iq-online.net.co\assets\images/');
        define('MAILER_ROOT', 'C:\xampp\htdocs\vive.iq-online.net.co\app\plugins\PHPMailer-master'.DS);

    } else {
        define('BASEPATH_IMAGE', '/var/www/vive.iq-online.net.co/assets/images/');
        define('MAILER_ROOT', '/var/www/vive.iq-online.net.co/app/plugins/PHPMailer-master'.DS);
        
        // define('BASEPATH_IMAGE', '/var/www/html/assets/images');
        // define('MAILER_ROOT', '/var/www/html/app/plugins/PHPMailer-master'.DS);
    }

    define('APP', ROOT.'app'.DS);
    define('CLASSES', APP.'classes'.DS);
    define('CONFIG', APP.'config'.DS);
    define('CONTROLLERS', APP.'controllers'.DS);
    define('FUNCTIONS', APP.'functions'.DS);
    define('MODELS', APP.'models'.DS);
    define('ASSETS_ROOT', ROOT.'assets'.DS);
    
    define('TEMPLATES', ROOT.'templates'.DS);
    define('INCLUDES', TEMPLATES.'includes'.DS);
    define('MODULES', TEMPLATES.'modules'.DS);
    define('VIEWS', TEMPLATES.'views'.DS);

    //Rutas de archivos o assets con base URL
    define('ASSETS', URL.'assets/');
    define('CSS', ASSETS.'css/');
    define('LIBS', ASSETS.'libs/');
    define('FAVICON', ASSETS.'favicon/');
    define('FONTS', ASSETS.'fonts/');
    define('IMAGES', ASSETS.'images/');
    define('JS', ASSETS.'js/');
    define('PLUGINS', ASSETS.'plugins/');
    define('UPLOADS', ASSETS.'uploads/');
    define('UPLOADS_ROOT', ROOT.'app/uploads'.DS);
    define('UPLOADS_ROOT_ASSETS', ROOT.'assets/uploads'.DS);

    if (IS_LOCAL) {
        //Credenciales BBDD local o desarrollo
        define('DB_ENGINE', 'mysql');
        define('DB_HOST', 'localhost');
        define('DB_PORT', 3307);
        define('DB_NAME', 'iq-vive');
        define('DB_NAME_AUX', 'framework');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_CHARSET', 'utf8mb4');
    } else {
        //Credenciales BBDD producción
        define('DB_ENGINE', 'mysql');
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'iq-vive');
        define('DB_NAME_AUX', 'iqgis-gestor');
        define('DB_USER', 'root');
        define('DB_PASS', 'zJ#P1Kd9G]?K3V1N');
        define('DB_CHARSET', 'utf8mb4');
    }

    //Controlador por defecto / Método por defecto / Controlador de errores por defecto
    define('DEFAULT_CONTROLLER', 'index');
    define('DEFAULT_CONTROLLER_ERROR', 'error');
    define('DEFAULT_METHOD', 'index');

