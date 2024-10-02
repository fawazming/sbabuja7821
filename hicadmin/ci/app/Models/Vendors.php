<?php
namespace App\Models;

use CodeIgniter\Model;

class Vendors extends Model
{
    protected $table = 'vendors';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name','acc_no','bank','access_code','pins','log','sheet','locked'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
