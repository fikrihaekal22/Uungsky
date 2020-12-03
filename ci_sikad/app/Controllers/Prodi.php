<?php

namespace App\Controllers;

use App\Models\ModelProdi;
use App\Models\ModelFakultas;

class Prodi extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelProdi = new ModelProdi();
        $this->ModelFakultas = new ModelFakultas();
    }
    // inisialisasi method index 
    public function index()
    {
        $data = [
            'title' => 'Program Studi',
            'prodi' => $this->ModelProdi->allData(),
            'isi' => 'admin/prodi/v_index',
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add()
    {
        $data = [
            'title'     => 'Add Program Studi',
            'fakultas'  => $this->ModelFakultas->allData(),
            'isi'       => 'admin/prodi/v_add',
        ];
        return view('layout/v_wrapper', $data);
    }

    public function insert()
    {
        if ($this->validate([
            'id_fakultas' => [
                'label' => 'Fakultas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'prodi' => [
                'label' => 'Program Studi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'jenjang' => [
                'label' => 'Jenjang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
        ])) {
            //jika valid
            $data = [
                'id_fakultas' => $this->request->getPost('id_fakultas'),
                'prodi' => $this->request->getPost('prodi'),
                'jenjang' => $this->request->getPost('jenjang')
            ];
            $this->ModelProdi->add($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!!!');
            return redirect()->to(base_url('prodi'));
        } else {
            //jika tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('prodi/add'));
        }
    }

    public function edit($id_prodi)
    {
        $data = [
            'title'     => 'Edit Program Studi',
            'fakultas'  => $this->ModelFakultas->allData(),
            'prodi'     => $this->ModelProdi->detail_Data($id_prodi),
            'isi'       => 'admin/prodi/v_edit',
        ];
        return view('layout/v_wrapper', $data);
    }

    public function update($id_prodi)
    {
        if ($this->validate([
            'id_fakultas' => [
                'label' => 'Fakultas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'prodi' => [
                'label' => 'Program Studi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'jenjang' => [
                'label' => 'Jenjang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
        ])) {
            //jika valid
            $data = [
                'id_prodi' => $id_prodi,
                'id_fakultas' => $this->request->getPost('id_fakultas'),
                'prodi' => $this->request->getPost('prodi'),
                'jenjang' => $this->request->getPost('jenjang')
            ];
            $this->ModelProdi->edit($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!!!');
            return redirect()->to(base_url('prodi'));
        } else {
            //jika tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('prodi/edit/' . $id_prodi));
        }
    }

    public function delete_data($id_prodi)
    {
        $data = [
            'id_prodi' => $id_prodi,
        ];
        $this->ModelProdi->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!!!');
        return redirect()->to(base_url('prodi'));
    }

    //--------------------------------------------------------------------

}