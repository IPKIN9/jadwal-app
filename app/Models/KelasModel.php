<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'id', '_kelas', 'jurusan_id',
        'created_at', 'updated_at'
    ];

    public function scopejoinList($query)
    {
        return $query
            ->leftJoin('jurusan as jurusan', 'kelas.jurusan_id', '=', 'jurusan.id')
            ->select(
                'kelas.id',
                'kelas._kelas',
                'kelas.jurusan_id',
                'jurusan._jurusan as _jurusan',
                'kelas.created_at',
                'kelas.updated_at',
            );
    }

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
                ->where('_kelas', 'LIKE', '%' . $params['search'] . '%')
                ->orWhere('_jurusan', 'LIKE', '%' . $params['search'] . '%');
        } else {
            return $query
                ->offset($page)
                ->limit($params['limit']);
        }
    }

    public function scopegetByJurusan($query, $params)
    {
        if ($params['jurusan_id']) {
            return $query->where('jurusan_id', $params['jurusan_id']);
        }
        return $query;
    }
}
