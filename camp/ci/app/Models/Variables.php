<?php
namespace App\Models;

use CodeIgniter\Model;

class Variables extends Model
{
    protected $table = 'variables';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name','value']; 

    protected $useTimestamps = false;
}
