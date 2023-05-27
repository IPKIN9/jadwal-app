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
                'model_a.nama_mapel as mata_pelajaran',
                'model_b._pangkat as pangkat',
                'guru.created_at',
                'guru.updated_at',
            );
    }

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if (strlen($params['search']) >= 1) {
            return $query
                ->where('nip', 'LIKE', '%' . $params['search'] . '%')
                ->orWhere('nama', 'LIKE', '%' . $params['search'] . '%')
                ->orWhere('mata_pelajaran', 'LIKE', '%' . $params['search'] . '%')
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
