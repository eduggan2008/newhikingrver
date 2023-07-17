<?php

class Session {

    public $session_id;
    public $session_role;
    public $session_first_name;
    public $session_last_name;
    public $session_email;
    public $session_picture;
    public $session_joined;

    public function __construct() {
        session_start();
        $this->session_id = $_SESSION['id'] ?? 0;
        $this->session_role = $_SESSION['role'] ?? 'public';
        $this->session_first_name = $_SESSION['first_name'] ?? '';
        $this->session_last_name = $_SESSION['last_name'] ?? '';
        $this->session_email = $_SESSION['email'] ?? '';
        $this->session_picture = $_SESSION['picture'] ?? '';
        $this->session_joined = $_SESSION['joined'] ?? '';
    }

    // Create a new session
    public function create($member) {
        session_regenerate_id(true);
        $_SESSION['id'] = $member['id'];
        $_SESSION['role'] = $member['role'];
        $_SESSION['first_name'] = $member['first_name'];
        $_SESSION['last_name'] = $member['last_name'];
        $_SESSION['email'] = $member['email'];
        $_SESSION['picture'] = $member['picture'];
        $_SESSION['joined'] = $member['joined'];
    }

    //Update an existing session
    public function update($member) {
        $this->create($member);
    }

    // Delete the existing session
    public function delete() {
        $_SESSION = [];
        $param = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 2400, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
        session_destroy();
    }

}

