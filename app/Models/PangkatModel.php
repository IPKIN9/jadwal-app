<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PangkatModel extends Model
{
    protected $table = 'pangkat';

    protected $fillable = [
        'id', '_pangkat', 'created_at', 'updated_at'
    ];

    public function scopesortered($query, $params)
    {
        if ($params['orderBy'] === 'created_at') {
            return $query
            ->orderBy('created_at', $params['sort']);
        } else {
            return $query
            ->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(" . $params['orderBy'] . ", ' ', -1), ' ', 1) AS UNSIGNED) " . $params['sort'])
            ->orderByRaw("SUBSTRING_INDEX(" . $params['orderBy'] . ", ' ', -1) " . $params['sort']);
        }
    }

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if (strlen($params['search']) >= 1) {
            return $query
                ->where('_pangkat', 'LIKE', '%' . $params['search'] . '%');
        } else {
            return $query
                ->offset($page)
                ->limit($params['limit']);
        }
    }
}
