<?php 
namespace App\Models;

use CodeIgniter\Model;
class Nasabah_model extends Model
{
    protected $table = 'm_nasabah';
    protected $primaryKey = 'id_nasabah';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_nasabah','nama','no_wa','alamat','nik'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // listing
    public function listing()
    {
        $builder = $this->db->table('m_nasabah');
        $builder->orderBy('m_nasabah.id_nasabah','DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

        // tambah
        public function tambah($data)
        {
            $builder = $this->db->table('m_nasabah');
            $builder->insert($data);
        }

    // total
    public function total()
    {
        $builder = $this->db->table('kategori');
        $builder->select('COUNT(*) AS total');
        $builder->orderBy('kategori.id_kategori','DESC');
        $query = $builder->get();
        return $query->getRowArray();
    }

    // detail
    public function detail($id_kategori)
    {
        $builder = $this->db->table('kategori');
        $builder->where('id_kategori',$id_kategori);
        $builder->orderBy('kategori.id_kategori','DESC');
        $query = $builder->get();
        return $query->getRowArray();
    }

    // read
    public function read($slug_kategori)
    {
        $builder = $this->db->table('kategori');
        $builder->where('slug_kategori',$slug_kategori);
        $builder->orderBy('kategori.id_kategori','DESC');
        $query = $builder->get();
        return $query->getRowArray();
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('kategori');
        $builder->where('id_kategori',$data['id_kategori']);
        $builder->update($data);
    }

}