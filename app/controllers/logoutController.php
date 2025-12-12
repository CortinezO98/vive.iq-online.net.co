<?php
    class logoutController extends Controller {
        function __construct()
        {
        }

        function index() {
            unset($_SESSION);
            session_destroy();
            Redirect::to('login');

        }
    }