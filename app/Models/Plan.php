<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // protected $connection = 'radius';
    protected $table = 'rm_services';

    public $timestamps = false; // 👈 disable timestamps

    protected $fillable = [
        'srvid',
        'srvname',
        'descr',
        'downrate',
        'uprate',
        'limitdl',
        'limitul',
        'limitcomb',
        'limitexpiration',
        'limituptime',
        'poolname',
        'unitprice',
        'unitpriceadd',
        'timebaseexp',
        'timebaseonline',
        'timeunitexp',
        'timeunitonline',
        'trafficunitdl',
        'trafficunitul',
        'trafficunitcomb',
        'inittimeexp',
        'inittimeonline',
        'initdl',
        'initul',
        'inittotal',
        'srvtype',
        'timeaddmodeexp',
        'timeaddmodeonline',
        'trafficaddmode',
        'monthly',
        'enaddcredits',
        'minamount',
        'minamountadd',
        'resetctrdate',
        'resetctrneg',
        'pricecalcdownload',
        'pricecalcupload',
        'pricecalcuptime',
        'unitpricetax',
        'unitpriceaddtax',
        'enableburst',
        'dlburstlimit',
        'ulburstlimit',
        'dlburstthreshold',
        'ulburstthreshold',
        'dlbursttime',
        'ulbursttime',
        'enableservice',
        'dlquota',
        'ulquota',
        'combquota',
        'timequota',
        'priority',
        'nextsrvid',
        'dailynextsrvid',
        'disnextsrvid',
        'availucp',
        'renew',
        'carryover',
        'policymapdl',
        'policymapul',
        'custattr',
        'gentftp',
        'cmcfg',
        'advcmcfg',
        'addamount',
        'ignstatip',
        'identity_id',
    ];

    public function identity()
    {
        return $this->belongsTo(Identity::class, 'identity_id');
    }
}
