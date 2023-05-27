<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurusanModel extends Model
{
    protected $table = 'jurusan';
    protected $fillable = [
        'id', '_jurusan', 'created_at', 'updated_at'
    ];

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if (strlen($params['search']) >= 1) {
            return $query
                ->where('_jurusan', 'LIKE', '%' . $params['search'] . '%')
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
