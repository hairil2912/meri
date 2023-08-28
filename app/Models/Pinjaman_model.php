<?php 
namespace App\Models;

use CodeIgniter\Model;

class Pinjaman_model extends Model
{

    protected $table = 'berita';
    protected $primaryKey = 'id_pinjaman';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $builder = $this->db->table('t_pinjaman as p');
        $builder->select('p.*, n.*, 
        COUNT(CASE WHEN d.status = 1 THEN 1 ELSE NULL END) as lunas,
        COUNT(CASE WHEN d.status = 0 THEN 1 ELSE NULL END) as blmlunas,
        SUM(CASE WHEN d.status = 0 THEN d.angsuranbulat ELSE 0 END) as sisaangsuran,
        SUM(CASE WHEN d.status = 1 THEN d.nil_bayar ELSE 0 END) as sudahbayar');
        $builder->join('m_nasabah n', 'n.id_nasabah = p.id_nasabah', 'LEFT');
        $builder->join('t_pinjaman_detail d', 'd.id_pinjaman = p.id_pinjaman', 'LEFT');
        $builder->orderBy('p.id_pinjaman', 'DESC');
        $builder->groupBy('p.id_pinjaman'); // Group by id_pinjaman to avoid duplicate rows
        $query = $builder->get();
        return $query->getResultArray();
    }


      // total
      public function total()
      {
          $builder = $this->db->table('t_pinjaman');
          $query = $builder->get();
          return $query->getNumRows();
      }
  
      // detail
      public function detail($id_pinjaman)
      {
        $builder = $this->db->table('t_pinjaman_detail d');
        $builder->select('p.*, d.*');
        $builder->join('t_pinjaman p', 'd.id_pinjaman = p.id_pinjaman', 'LEFT');
        $builder->where(['d.id_pinjaman' => $id_pinjaman]);
        $builder->orderBy('d.bulan', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
        
      }

      public function pinjamandetail()
      {
        $builder = $this->db->table('t_pinjaman_detail d');
        $builder->select('p.*, d.*');
        $builder->join('t_pinjaman p', 'd.id_pinjaman = p.id_pinjaman', 'LEFT');
        $builder->orderBy('d.bulan', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
        
      }

      public function detail_nasabah($id_pinjaman)
      {
        $builder = $this->db->table('t_pinjaman p');
        $builder->select('p.*, n.*');
        $builder->join('m_nasabah n', 'n.id_nasabah = p.id_nasabah', 'LEFT');
        $builder->where(['p.id_pinjaman' => $id_pinjaman]);
        $query = $builder->get();
          return $query->getRowArray();
      }


    // home
    public function beranda()
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'status_berita' => 'Publish',
                            'jenis_berita'  => 'Berita']);
        $builder->orderBy('berita.tanggal_publish','DESC');
        $builder->limit(3);
        $query = $builder->get();
        return $query->getResultArray();
    }

    // home
    public function sidebar()
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'status_berita' => 'Publish',
                            'jenis_berita'  => 'Berita']);
        $builder->orderBy('berita.tanggal_publish','DESC');
        $builder->limit(10);
        $query = $builder->get();
        return $query->getResultArray();
    }


    // home
    public function home()
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'status_berita' => 'Publish',
                            'jenis_berita'  => 'Berita']);
        $builder->orderBy('berita.tanggal_publish','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // kategori
    public function kategori($id_kategori)
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'status_berita'         => 'Publish',
                            'jenis_berita'          => 'Berita',
                            'berita.id_kategori'    => $id_kategori]);
        $builder->orderBy('berita.tanggal_publish','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // kategori
    public function kategori_all($id_kategori)
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'berita.id_kategori'    => $id_kategori]);
        $builder->orderBy('berita.tanggal_publish','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // total
    public function total_kategori($id_kategori)
    {
        $builder = $this->db->table('berita')->where('id_kategori',$id_kategori);
        $query = $builder->get();
        return $query->getNumRows();
    }

    // author
    public function author_all($id_user)
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'berita.id_user'    => $id_user]);
        $builder->orderBy('berita.id_berita','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // total
    public function total_author($id_user)
    {
        $builder = $this->db->table('berita')->where('id_user',$id_user);
        $query = $builder->get();
        return $query->getNumRows();
    }

    // kategori
    public function jenis_berita_all($jenis_berita)
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'berita.jenis_berita'    => $jenis_berita]);
        $builder->orderBy('berita.id_berita','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // total
    public function total_jenis_berita($jenis_berita)
    {
        $builder = $this->db->table('berita')->where('jenis_berita',$jenis_berita);
        $query = $builder->get();
        return $query->getNumRows();
    }

    // status_berita
    public function status_berita_all($status_berita)
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where( [  'berita.status_berita'    => $status_berita]);
        $builder->orderBy('berita.id_berita','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // status_berita
    public function total_status_berita($status_berita)
    {
        $builder = $this->db->table('berita')->where('status_berita',$status_berita);
        $query = $builder->get();
        return $query->getNumRows();
    }

  

    // read
    public function read($slug_berita)
    {
        $builder = $this->db->table('berita');
        $builder->select('berita.*, kategori.nama_kategori, kategori.slug_kategori, users.nama');
        $builder->join('kategori','kategori.id_kategori = berita.id_kategori','LEFT');
        $builder->join('users','users.id_user = berita.id_user','LEFT');
        $builder->where('berita.slug_berita',$slug_berita);
        $builder->where('berita.status_berita','Publish');
        $builder->orderBy('berita.id_berita','DESC');
        $query = $builder->get();
        return $query->getRowArray();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('t_pinjaman');
        $builder->insert($data);
    }

    public function tambahdetail($detailData)
    {
        $builder = $this->db->table('t_pinjaman_detail');
        $builder->insert($detailData);
    }

    // tambah
    public function edit($data)
    {
        $builder = $this->db->table('berita');
        $builder->where('id_berita',$data['id_berita']);
        $builder->update($data);
    }

}