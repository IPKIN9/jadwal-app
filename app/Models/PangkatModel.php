<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PangkatModel extends Model
{
    protected $table = 'pangkat';

    protected $fillable = [
        'id', '_pangkat', 'created_at', 'updated_at'
    ];

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if (strlen($params['search']) >= 1) {
            return $query
                ->where('_pangkat', 'LIKE', '%' . $params['search'] . '%')
                ->offset($page)
                ->limit($params['limit'])
                ->orderBy($params['orderBy'], $params['sort']);
        } else {
            return $query
                ->offset($page)
                ->limit($params['limit'])
                ->orderBy($params['orderBy'], $params['sort']);
        }
    }
}
