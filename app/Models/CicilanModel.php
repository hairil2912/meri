<?php

namespace App\Models;

use CodeIgniter\Model;

class CicilanModel extends Model
{
    protected $table = 't_pinjaman_detail'; // Ganti dengan nama tabel yang sesuai
    protected $primaryKey = 'id_pinjaman_detail';

    protected $allowedFields = ['nil_bayar', 'status','bukti','tgl_bayar'];
}
