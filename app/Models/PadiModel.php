<?php

namespace App\Models;

use CodeIgniter\Model;

class PadiModel extends Model
{
    protected $table            = 'data_padi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama_petani', 'nama_pabrik', 'jumlah_padi', 'gambar'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // public function getPadi(){
    //     return $this->getPadi()->findAll();
    // }


}
