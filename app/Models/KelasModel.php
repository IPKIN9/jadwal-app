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

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if (strlen($params['search']) >= 1) {
            return $query
                ->where('_kelas', 'LIKE', '%' . $params['search'] . '%')
                ->orWhere('_jurusan', 'LIKE', '%' . $params['search'] . '%')
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
