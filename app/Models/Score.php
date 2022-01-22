<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    public function quizzes(){
        return $this->belongsTo('Quiz');
    }
    public function users(){
        return $this->belongsTo('User');
    }
       
}
