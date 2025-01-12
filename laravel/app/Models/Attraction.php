<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    use HasFactory;

    protected $table = 'attractions'; // Az adatbázis tábla neve
    protected $primaryKey = 'attractions_id'; // A táblában használt elsődleges kulcs

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_attractions', 'attractions_id', 'tour_id')
                    ->withPivot('attraction_order');
    }
}
