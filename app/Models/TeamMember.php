<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'role',
        'bio',
        'photo',
    ];

    /** Accessor: huruf awal nama untuk avatar. */
    protected function initial(): Attribute
    {
        return Attribute::get(fn () => strtoupper(mb_substr($this->name, 0, 1)));
    }
}
