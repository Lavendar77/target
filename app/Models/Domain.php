<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'base_url',
        'reference',
    ];

    /**
     * Get the owning user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the domain rules.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DomainRule::class, 'domain_id');
    }
}
