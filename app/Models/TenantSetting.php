<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'value',
    ];
    // Phương thức để lấy cài đặt theo key
    public static function getSetting($key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }
}
