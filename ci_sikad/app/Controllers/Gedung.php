<?php

namespace App\Controllers;

use App\Models\ModelGedung;

class gedung extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->ModelGedung = new ModelGedung();
    }
    // inisialisasi method index 
    public function index()
    {
        $data = [
            'title'     => 'Gedung',
            'gedung'  => $this->ModelGedung->allData(),
            'isi'       => 'admin/v_gedung',
        ];
        return view('layout/v_wrapper', $data);
    }

    public function add()
    {
        $data = [
            'gedung' => $this->request->getPost('gedung'),
        ];
        $this->ModelGedung->add($data);
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan!!!');
        return redirect()->to(base_url('gedung'));
    }

    public function edit($id_gedung)
    {
        $data = [
            'id_gedung' => $id_gedung,
            'gedung' => $this->request->getPost('gedung'),
        ];
        $this->ModelGedung->edit($data);
        session()->setFlashdata('pesan', 'Data Berhasil Diupdate!!!');
        return redirect()->to(base_url('gedung'));
    }

    public function delete_data($id_gedung)
    {
        $data = [
            'id_gedung' => $id_gedung,
        ];
        $this->ModelGedung->delete_data($data);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus!!!');
        return redirect()->to(base_url('gedung'));
    }


    //--------------------------------------------------------------------

}