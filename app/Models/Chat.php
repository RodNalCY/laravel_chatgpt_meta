<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'whatsapp_number'];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
