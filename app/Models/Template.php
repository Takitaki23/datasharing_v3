<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'template_name','canvas_width','canvas_height','profile_x','profile_y',
        'textContents-0-x','textContents-0-y',
        'textContents-1-x','textContents-1-y',
        'textContents-2-x','textContents-2-y',
        'textContents-3-x','textContents-3-y',
        'textContents-4-x','textContents-4-y',
    ];
    use HasFactory;
}
