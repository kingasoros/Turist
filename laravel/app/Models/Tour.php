<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours';
    protected $primaryKey = 'tour_id';

    public function isFavorite($userId)
    {
        return DB::table('turist_favorites')
                 ->where('id', $userId)
                 ->where('tour_id', $this->tour_id)
                 ->exists();
    }

    public function attractions()
    {
        return $this->belongsToMany(Attraction::class, 'tour_attractions', 'tour_id', 'attractions_id')
                    ->withPivot('attraction_order');
    }
}
