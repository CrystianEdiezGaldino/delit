<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{
    public function index()
    {
        // Verifica se o usuário está logado
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Carrega a view da index
        return view('index');
    }

    public function login()
    {
        // Se o usuário já estiver logado, redireciona para a index
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        // Carrega a view de login
        return view('login');
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

                return redirect()->to(site_url('/'));
            } else {
                session()->setFlashdata('error', 'Senha incorreta');
                return redirect()->to(site_url('login'));
            }
        } else {
            session()->setFlashdata('error', 'Usuário não encontrado');
            return redirect()->to(site_url('login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function menus()
    {
        // Verifica se o usuário está logado
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Verifica o nível de acesso
        $role = session()->get('role');
        $grau = session()->get('grau');

        $data = [];

        if ($role === 'admin') {
            $data['menus'] = ['Menu 1', 'Menu 2', 'Menu 3']; // Todos os menus para admin
        } else {
            // Menus baseados no grau do usuário
            switch ($grau) {
                case 1:
                    $data['menus'] = ['Menu 1'];
                    break;
                case 2:
                    $data['menus'] = ['Menu 1', 'Menu 2'];
                    break;
                default:
                    $data['menus'] = [];
                    break;
            }
        }

        return view('menus', $data);
    }
    public function perfil()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $ime = session()->get('ime');
    
        // Buscar informações na tabela pk_usuarios
        $db = \Config\Database::connect();
        $pkUsuario = $db->table('pk_usuarios')
                        ->where('ime_num', $ime)
                        ->get()
                        ->getRowArray();
    
        $data = [
            'usuario' => $pkUsuario
        ];
    
        return view('perfil', $data);
    }
}
