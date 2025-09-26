<?php
namespace App\Models;

use CodeIgniter\Model;

class Delegates25 extends Model
{
    protected $table = 'delegates25';
    protected $primaryKey = 'txn';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['txn','SBID','fname','lname','lb','phone','email','category','school','level','dept','ref','old','paid','gender','org','house'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
