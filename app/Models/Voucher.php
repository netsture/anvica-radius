<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'rm_cards';       // table name
    protected $primaryKey = 'id';        // primary key
    public $incrementing = false;        // id is not auto increment
    protected $keyType = 'string';       // if bigint, use 'int'

    public $timestamps = false;          // no created_at/updated_at

    protected $fillable = [
        'id',
        'cardnum',
        'password',
        'value',
        'expiration',
        'series',
        'date',
        'owner',
        'used',
        'cardtype',
        'revoked',
        'downlimit',
        'uplimit',
        'comblimit',
        'uptimelimit',
        'srvid',
        'transid',
        'active',
        'expiretime',
        'timebaseexp',
        'timebaseonline',
    ];
}
