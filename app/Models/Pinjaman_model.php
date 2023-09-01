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


    public function wa($id_pinjaman)
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
    $builder->where('p.id_pinjaman', $id_pinjaman); // Filter by id_pinjaman
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

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('berita');
        $builder->where('id_berita',$data['id_berita']);
        $builder->update($data);
    }

    public function getTransaksi()
    {
        $keluarQuery = $this->getKeluarQuery();
        $masukQuery = $this->getMasukQuery();

        $query = $this->db->query("SELECT * FROM ($keluarQuery UNION ALL $masukQuery) AS transaksi WHERE tgl_transaksi IS NOT NULL ORDER BY id_pinjaman, tgl_transaksi ASC");
        return $query->getResult();
    }

    private function getKeluarQuery()
    {
        return "(SELECT p.id_pinjaman, n.nama, p.tgl_pinjaman AS tgl_transaksi, 'Keluar' AS jenis_transaksi, 0 AS masuk, p.pinjaman AS keluar FROM t_pinjaman p JOIN m_nasabah n ON n.id_nasabah = p.id_nasabah WHERE p.jenis = 2)";
    }

    private function getMasukQuery()
    {
        return "(SELECT p.id_pinjaman, n.nama, pd.tgl_bayar AS tgl_transaksi, 'Masuk' AS jenis_transaksi, pd.nil_bayar AS masuk, 0 AS keluar FROM t_pinjaman p JOIN t_pinjaman_detail pd ON p.id_pinjaman = pd.id_pinjaman JOIN m_nasabah n ON n.id_nasabah = p.id_nasabah WHERE pd.jenis = 1)";
    }

}