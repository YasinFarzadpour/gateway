<?php
namespace Larabookir\Gateway\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gateway_id',
        'gateway_details'
    ];

    function getTable()
    {
        return config('gateway.table-gateway-users', 'gateway_users');
    }
}
