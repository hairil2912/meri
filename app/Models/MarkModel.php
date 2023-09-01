<?php

namespace App\Models;

use CodeIgniter\Model;

class MarkModel extends Model
{
    protected $table = 'marks'; // Nama tabel di database
    protected $primaryKey = 'id';
    protected $allowedFields = ['x', 'y', 'note']; // Kolom yang diizinkan diisi

    // Tambahkan metode lain sesuai kebutuhan
}
