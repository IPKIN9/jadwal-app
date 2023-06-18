<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruModel extends Model
{

    protected $table = 'guru';

    protected $fillable = [
        'id', 'nama', 'nip', 'mapel_id', 'pangkat_id', 'jumlah_jam', 'ket',
        'created_at', 'updated_at'
    ];

    public function scopejoinList($query)
    {
        return $query
            ->leftJoin('mapel as model_a', 'guru.mapel_id', '=', 'model_a.id')
            ->leftJoin('pangkat as model_b', 'guru.pangkat_id', '=', 'model_b.id')
            ->select(
                'guru.id',
                'guru.nama',
                'guru.nip',
                'guru.mapel_id',
                'guru.pangkat_id',
                'guru.jumlah_jam',
                'guru.ket',
                'model_a.nama_mapel as mata_pelajaran',
                'model_b._pangkat as pangkat',
                'guru.created_at',
                'guru.updated_at',
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
                ->where('nama', 'LIKE', '%' . $params['search'] . '%')
                ->orWhere('model_a.nama_mapel', 'LIKE', '%' . $params['search'] . '%');
        } else {
            return $query
                ->offset($page)
                ->limit($params['limit']);
        }
    }
}
