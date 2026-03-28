<?php
namespace Ekramul\SecurityGuard\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    protected $fillable = ['file_path','quarantined_path','detected_at'];
}
