<?php
    class errorController extends Controller {
        function __construct()
        {
        }

        function index() {
            $data =
            [
                'title' => 'Página no encontrada'

            ];

            View::render('404', $data);
        }
    }