<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $appends = ["open"];

    protected $fillable = [
        "text",
        "duration",
        "progress",
        "start_date",
        "parent"
    ];
    public function getOpenAttribute(){
        return true;
    }
}
