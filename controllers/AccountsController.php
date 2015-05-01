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

    public function edit() {
        $this->authorize();

        if($this->isPost) {
            if ($_POST['form'] == 'editProfile') {
                $username = $_SESSION['username'];
                $fullName = $_POST['fullName'];
                $email = $_POST['email'];

                $isChanged = $this->db->editProfile($username, $fullName, $email);
                if ($isChanged) {
                    $this->addSuccessMessage('Successful edit profile');
                } else {
                    $this->addErrorMessage("Editing a profile failed");
                }
            }

            if ($_POST['form'] == 'editPassword') {
                $username = $_SESSION['username'];
                $oldPassword = $_POST['password'];
                $newPassword = $_POST['newPassword'];
                $confirmPassword = $_POST['confirmPassword'];
                if($oldPassword == null || strlen($oldPassword) < 3 ||
                        $newPassword == null || strlen($newPassword) < 3 ||
                        $confirmPassword == null || strlen($confirmPassword) < 3 ||
                        $newPassword != $confirmPassword){
                    $this->addErrorMessage("Wrong data");
                    $this->redirect('accounts', 'edit');
                }

                $isChanged = $this->db->editPassword($username, $oldPassword, $newPassword);
                if ($isChanged) {
                    $this->addSuccessMessage('Successful edit password');
                    $this->redirect('accounts', 'edit');
                } else {
                    $this->addErrorMessage("Editing a password failed. Check your old password.");
                    $this->redirect('accounts', 'edit');
                }
            }
        }
            $this->userInfo = $this->db->getInfo($_SESSION['username']);
            $this->renderView(__FUNCTION__);
    }
}