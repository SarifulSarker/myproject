<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class childcategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'subcategory_id', 'childcateogry_slug',
        'childcategory_name'

];
    public function category(){
    	return $this->belongsTo(Category::class);
    }
    public function subcategory(){
    	return $this->belongsTo(subcategory::class);
    }

}
