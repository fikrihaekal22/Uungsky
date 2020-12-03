<?php

namespace App\Controllers;

use App\Models\ModelAuth as ModelsModelAuth;
use Config\App\Models\ModelAuth;

class Auth extends BaseController
{
    // bagian helpoer untuk form yang ada di v_login (<?php form_open / form close)
    public function __construct()
    {
        helper('form');
        $this->ModelAuth = new ModelsModelAuth();
    }
    // inisialisasi method index 
    public function index()
    {
        $data = [
            'title' => 'Login',
            'isi' => 'v_login',
        ];
        return view('layout/v_wrapper', $data);
    }
    //method untuk auth login berdasarkan level
    public function cek_login()
    {


        if ($this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'level' => [
                'label' => 'Level',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
        ])) {
            // jika valid
            $level = $this->request->getPost('level');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            if ($level == 1) {
                $cek_user = $this->ModelAuth->login_user($username, $password);
                if ($cek_user) {
                    // jika data cocok dengan database 
                    session()->set('log', true);
                    session()->set('username', $cek_user['username']);
                    session()->set('nama', $cek_user['nama_user']);
                    session()->set('foto', $cek_user['foto']);
                    session()->set('level', $level);
                    // akan login 
                    return redirect()->to(base_url('admin'));
                } else {
                    // jika data tidak cocok 
                    session()->setFlashdata('pesan', 'Login Gagal !, Username atau Password Salah');
                    return redirect()->to(base_url('auth'));
                }
            } elseif ($level == 2) {
                echo 'Mahasiswa';
            } elseif ($level == 3) {
                echo 'Dosen';
            }
        } else {
            //jika tidak valid 
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('auth'));
        }
    }
    public function logout()
    {
        session()->remove('log');
        session()->remove('username');
        session()->remove('nama');
        session()->remove('foto');
        session()->remove('level');
        session()->setFlashdata('success', 'Logout Sukses!');
        return redirect()->to(base_url('auth'));
    }
    //--------------------------------------------------------------------

}