<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Order extends Model
{
    use Searchable;

    protected $table = 'attractions';

    protected $fillable = ['name'];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name, 
        ];
    }
}
