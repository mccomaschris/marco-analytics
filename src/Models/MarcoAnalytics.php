<?

namespace McComasChris\MarcoAnalytics\Models;

use Illuminate\Database\Eloquent\Model;

class MarcoAnalytics extends Model
{
    protected $fillable = ['url', 'browser', 'device', 'ip_address'];
}
