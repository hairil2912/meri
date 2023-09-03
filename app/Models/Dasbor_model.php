<?php 
namespace App\Models;

use CodeIgniter\Model;

class Dasbor_model extends Model
{

    public function getDataJatuhTempo()
    {
        $builder = $this->db->table('t_pinjaman_detail pd');
        $builder->select('pd.id_pinjaman_detail,
        m_nasabah.no_wa,
        m_nasabah.nama, 
        pd.nil_pokok,
        pd.angsuran_perbulan,
        pd.j_tempo'); 
        $builder->join('t_pinjaman t_pinjaman', 'pd.id_pinjaman = t_pinjaman.id_pinjaman');
        $builder->join('m_nasabah', 't_pinjaman.id_nasabah = m_nasabah.id_nasabah');
        $builder->where('pd.status', 0);
        $builder->where('DATEDIFF(pd.j_tempo, NOW()) <=', 11);
        // $builder->limit(2);
        $builder->orderBy('t_pinjaman.id_pinjaman', 'DESC');
        $builder->groupBy('t_pinjaman.id_pinjaman'); // Group by id_pinjaman to avoid duplicate rows
        $query = $builder->get();
        return $query->getResultArray();
    }



    public function pinjaman()
    {
        $builder = $this->db->table('t_pinjaman');
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function nasabah()
    {
        $builder = $this->db->table('m_nasabah');
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function totalpinjaman()
    {
        $builder = $this->db->table('t_pinjaman');
        $builder->selectSum('pinjaman');
        $builder->selectSum('totalpinjam');
        $builder->selectSum('totalbunga');
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function cicilanberjalan()
    {
        $builder = $this->db->table('t_pinjaman_detail');
        $builder->selectSum('angsuranbulat');
        $builder->selectSum('nil_pokok');
        $builder->selectSum('nil_pokok');
        $builder->where('status', 0);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function cicilanlunas()
    {
        $builder = $this->db->table('t_pinjaman_detail');
        $builder->selectSum('angsuranbulat');
        $builder->selectSum('nil_pokok');
        $builder->selectSum('bunga');
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function totalbayar()
    {
        $builder = $this->db->table('t_pinjaman_detail');
        $builder->selectSum('nil_bayar');
        $query = $builder->get();
        return $query->getRowArray();
    }


    
    


    // video
    public function video()
    {
        $builder = $this->db->table('video');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // download
    public function download()
    {
        $builder = $this->db->table('download');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // staff
    public function staff()
    {
        $builder = $this->db->table('staff');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // kategori_download
    public function kategori_download()
    {
        $builder = $this->db->table('kategori_download');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // kategori
    public function kategori()
    {
        $builder = $this->db->table('kategori');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // kategori_staff
    public function kategori_staff()
    {
        $builder = $this->db->table('kategori_staff');
        $query = $builder->get();
        return $query->getNumRows();
    }

}