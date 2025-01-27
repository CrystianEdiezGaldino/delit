<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function login()
    {
        // Se o usuário já estiver logado, redireciona para a página inicial
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        // Carrega a view de login
        return view('auth/login');
    }

    public function auth()
    {
        $model = new UsuarioModel();

        $ime = $this->request->getPost('ime');
        $senha = $this->request->getPost('senha');

        $user = $model->buscarPorIme($ime);

        if ($user) {
            if (password_verify($senha, $user['senha'])) {
                $session = session();
                $session->set([
                    'id' => $user['id'],
                    'ime' => $user['ime'],
                    'nome' => $user['nome'],
                    'role' => $user['role'],
                    'grau' => $user['grau'],
                    'logged_in' => TRUE
                ]);

                return redirect()->to('/');
            } else {
                session()->setFlashdata('error', 'Senha incorreta');
                return redirect()->to('/login');
            }
        } else {
            session()->setFlashdata('error', 'Usuário não encontrado');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
