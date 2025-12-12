<?php
    class ayudaController extends Controller {
        function __construct()
        {
        }

        function login() {
            Controller::checkSesion();
            
            try {
                

                $data =
                [
                    'titulo_pagina' => 'DOCUMENTACIÓN|MANUAL DE USUARIO|LOGIN',
                ];
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            View::render('login', $data);
        }

        function navegacion() {
            Controller::checkSesion();
            
            try {
                

                $data =
                [
                    'titulo_pagina' => 'DOCUMENTACIÓN|MANUAL DE USUARIO|NAVEGACIÓN',
                ];
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            View::render('navegacion', $data);
        }

        function hoja_vida() {
            Controller::checkSesion();
            
            try {
                

                $data =
                [
                    'titulo_pagina' => 'DOCUMENTACIÓN|MANUAL DE USUARIO|HOJA DE VIDA',
                ];
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            View::render('hoja-vida', $data);
        }

        function aspirantes() {
            Controller::checkSesion();
            
            try {
                

                $data =
                [
                    'titulo_pagina' => 'DOCUMENTACIÓN|MANUAL DE USUARIO|ASPIRANTES',
                ];
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            View::render('aspirantes', $data);
        }

        function encuestas() {
            Controller::checkSesion();
            
            try {
                

                $data =
                [
                    'titulo_pagina' => 'DOCUMENTACIÓN|MANUAL DE USUARIO|ENCUESTAS',
                ];
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            View::render('encuestas', $data);
        }

        function administrador() {
            Controller::checkSesion();
            
            try {
                

                $data =
                [
                    'titulo_pagina' => 'DOCUMENTACIÓN|MANUAL DE USUARIO|ADMINISTRADOR',
                ];
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            View::render('administrador', $data);
        }
    }