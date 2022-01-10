<?php

namespace Laravolt\OnlyOffice\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlyOfficeTokens extends Model
{
    use HasFactory;

    protected $table = "onlyoffice_tokens";

    protected $fillable = ['user_id', 'token', 'expired_at'];
}
