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
                ->where('kode', 'LIKE', '%' . $params['search'] . '%')
                ->orWhere('kelas', 'LIKE', '%' . $params['search'] . '%');
        } else {
            return $query
                ->offset($page)
                ->limit($params['limit']);
        }
    }
}
