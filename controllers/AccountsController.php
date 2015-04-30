<?php

class AccountsController extends BaseController {
    private $db;

    public function onInit() {
        $this->db = new AccountsModel();
        $this->title = "Account";
    }

    public function register() {
        if($this->isPost) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if($username == null || strlen($username) < 3){
                $this->addErrorMessage('Username is required and min length is 3 symbols');
                $this->redirect('accounts', 'register');
            }
            if($password == null || strlen($password) < 3){
                $this->addErrorMessage('Password is required and min length is 3 symbols');
                $this->redirect('accounts', 'register');
            }
            $email = $_POST['email'];
            $fullName = $_POST['fullName'];
            $isRegister = $this->db->register($username, $password, $email, $fullName);
            if($isRegister) {
                $_SESSION['username'] = $username;
                $this->addSuccessMessage("Successful register!");
                $this->redirect('questions');
            } else
            {
                $this->addErrorMessage("Register failed!");
            }
        }
        $this->renderView(__FUNCTION__);
    }

    public function login() {
        if($this->isPost) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if($username == null || strlen($username) < 3){
                $this->addErrorMessage('Username is required and min length is 3 symbols');
                $this->redirect('accounts', 'register');
            }
            if($password == null || strlen($password) < 3){
                $this->addErrorMessage('Password is required and min length is 3 symbols');
                $this->redirect('accounts', 'register');
            }
            $isLogin = $this->db->login($username, $password);
            if($isLogin) {
                $_SESSION['username'] = $username;
                $this->addSuccessMessage("Successful Login!");
                $this->redirect('questions');
            } else {
                $this->addErrorMessage("Invalid Username or Password");
                $this->redirect('accounts', 'login');
            }
        }
        $this->renderView(__FUNCTION__);
    }

    public function logout() {
        $this->authorize();
        unset($_SESSION['username']);
        $this->addSuccessMessage("Successful logout!");
        $this->redirect('home');
    }
}