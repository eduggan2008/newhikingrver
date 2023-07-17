<?php
class CMS {

    protected $db = null;
    protected $article = null;
    protected $category = null;
    protected $member = null;
    protected $session = null;
    protected $token = null;

    public function __construct($dsn, $username, $password) {
        $this->db = new Database($dsn, $username, $password);
    }

    public function getArticle() {
        if($this->article === null) {
            $this->article = new Article($this->db);
        }
        return $this->article;
    }

    public function getCategory() {
        if($this->category === null) {
            $this->category = new Category($this->db);
        }
        return $this->category;
    }

    public function getMember() {
        if($this->member === null) {
            $this->member = new Member($this->db);
        }
        return $this->member;
    }


    public function getSession()
    {
        if ($this->session === null) {                   // If $session property null
            $this->session = new Session($this->db);     // Create Session object
        }
        return $this->session;                           // Return Session object
    }

    public function getToken()
    {
        if ($this->token === null) {                     // If $token property null
            $this->token = new Token($this->db);         // Create Token object
        }
        return $this->token;                             // Return Token object
    }

}