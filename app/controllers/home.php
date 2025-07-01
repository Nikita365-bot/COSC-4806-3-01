<?php

class Home extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== 1) {
            die('Not authenticated. Session not found.');
        }

        echo "Home controller accessed as: " . $_SESSION['username'];
        $this->view('home/index', [
            'username' => $_SESSION['username']
        ]);
    }
