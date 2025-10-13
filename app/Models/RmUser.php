<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class RmUser extends Model
{
    use HasFactory;

    protected $table = 'rm_users';

    // Primary key is username
    protected $primaryKey = 'username';
    
    public $incrementing = false;   // Since 'username' is a string primary key
    protected $keyType = 'string';

    // No timestamps (no created_at, updated_at)
    public $timestamps = false;

    // Fillable fields (use guarded alternatively if preferred)
    protected $fillable = [
        'identity_id',
        'username',
        'password',
        'macpswmode',
        'groupid',
        'enableuser',
        'uplimit',
        'downlimit',
        'comblimit',
        'firstname',
        'lastname',
        'company',
        'phone',
        'mobile',
        'address',
        'city',
        'zip',
        'country',
        'state',
        'comment',
        'gpslat',
        'gpslong',
        'mac',
        'usemacauth',
        'expiration',
        'uptimelimit',
        'srvid',
        'staticipcm',
        'staticipcpe',
        'ipmodecm',
        'ipmodecpe',
        'poolidcm',
        'poolidcpe',
        'createdon',
        'acctype',
        'credits',
        'cardfails',
        'createdby',
        'owner',
        'taxid',
        'cnic',
        'email',
        'maccm',
        'custattr',
        'warningsent',
        'verifycode',
        'verified',
        'selfreg',
        'verifyfails',
        'verifysentnum',
        'verifymobile',
        'contractid',
        'contractvalid',
        'actcode',
        'pswactsmsnum',
        'alertemail',
        'alertsms',
        'lang',
        'lastlogoff',
        'autorenew'
    ];

    public static function rules($id = null, $identity_id = null)
    {
        return [
            'identity_id' => ['required'],
            'srvid' => ['required'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rm_users')
                    ->where(fn($q) => $q->where('identity_id', $identity_id))
                    ->ignore($id), // optional for update
            ],
            'password'  => ['required', 'min:4'],
            'mobile'    => ['required'],
        ];
    }
}
