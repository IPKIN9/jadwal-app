<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'id', 'kode', 'kelas_id', 'ket',
        'created_at', 'updated_at'
    ];

    public function scopejoinList($query)
    {
        return $query
            ->leftJoin('kelas as model_a', 'jadwal.kelas_id', '=', 'model_a.id')
            ->select(
                'jadwal.id',
                'jadwal.kode',
                'jadwal.kelas_id',
                'jadwal.ket',
                'model_a._kelas as kelas',
                'jadwal.created_at',
                'jadwal.updated_at',
            );
    }

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if (strlen($params['search']) >= 1) {
            return $query
                ->where('kode', 'LIKE', '%' . $params['search'] . '%')
                ->orWhere('kelas', 'LIKE', '%' . $params['search'] . '%')
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
