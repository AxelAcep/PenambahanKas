<?php

namespace App\Models;

use CodeIgniter\Model;

class KasModel extends Model
{
    protected $table      = 'kas';
    protected $primaryKey = 'kode_kas';
    protected $useAutoIncrement = false;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false; // Jika Anda tidak menggunakan soft delete

    protected $allowedFields = ['kode_kas', 'kategori', 'jumlah', 'tanggal', 'jenis_kas', 'user_id'];

    // Dates
    protected $useTimestamps = false; // Jika Anda tidak menggunakan created_at, updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getKasPemasukanFiltered($bulan = null, $tahun = null)
    {
        $builder = $this->db->table($this->table);
        $builder->where('jenis_kas', 'pemasukan');

        if (!empty($bulan) && $bulan !== 'all') { // 'all' bisa jadi nilai default untuk "Semua Bulan"
            $builder->where('MONTH(tanggal)', $bulan);
        }
        if (!empty($tahun) && $tahun !== 'all') { // 'all' bisa jadi nilai default untuk "Semua Tahun"
            $builder->where('YEAR(tanggal)', $tahun);
        }

        $builder->orderBy('tanggal', 'DESC');
        return $builder->get()->getResultArray();
    }
}