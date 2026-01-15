<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        $this->render('auth/login', ['title' => 'Connexion']);
    }

    public function showRegister()
    {
        $this->render('auth/register', ['title' => 'Inscription']);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (User::findByEmail($_POST['email'])) {
                $this->render('auth/register', ['error' => 'Email already registered', 'title' => 'Inscription']);
                return;
            }

            $user = new User();
            $user->setFirstName($_POST['first_name']);
            $user->setLastName($_POST['last_name']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));

            if ($user->save()) {
                $this->redirect('/login');
            } else {
                $this->render('auth/register', ['error' => 'Registration failed', 'title' => 'Inscription']);
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getFirstName();
                $_SESSION['user_role'] = $user->getRole();
                $this->redirect('/');
            } else {
                $this->render('auth/login', ['error' => 'Invalid credentials', 'title' => 'Connexion']);
            }
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
}
