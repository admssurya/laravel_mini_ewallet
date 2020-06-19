<?php


namespace App\Models;


use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractBaseModel extends Model
{
    use SoftDeletes;
    use Uuid;

    public $incrementing = false;
    protected $dateFormat = 'Y-m-d H:i:s';
}
