<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailJadwalModel extends Model
{
    protected $table = 'detail_jadwal';

    protected $fillable = [
        'id', 'jadwal_id', 'guru_id', 'mapel', 'jumlah_jam', 'tgl', 'jam_masuk', 'jam_keluar',
        'created_at', 'updated_at'
    ];

    public function scopejoinList($query)
    {
        return $query
            ->leftJoin('jadwal as model_a', 'detail_jadwal.jadwal_id', '=', 'model_a.id')
            ->leftJoin('guru as model_b', 'detail_jadwal.guru_id', '=', 'model_b.id')
            ->select(
                'detail_jadwal.id',
                'model_a.kode as kode',
                'detail_jadwal.jadwal_id',
                'model_b.nama as guru',
                'detail_jadwal.mapel',
                'detail_jadwal.jumlah_jam',
                'detail_jadwal.tgl',
                'detail_jadwal.jam_masuk',
                'detail_jadwal.jam_keluar',
                'detail_jadwal.created_at',
                'detail_jadwal.updated_at',
            );
    }

    public function scopepagginateList($query, $params)
    {
        $page = ($params['page'] - 1) * $params['limit'];
        if ($params['jadwal_id'] | strlen($params['search']) >= 1) {
            return $query
                ->where('jadwal_id', $params['jadwal_id'])
                ->where(function ($q) use ($params) {
                    $q->where('kode', 'LIKE', '%' . $params['search'] . '%')
                        ->orWhere('model_b.nama', 'LIKE', '%' . $params['search'] . '%')
                        ->orWhere('mapel', 'LIKE', '%' . $params['search'] . '%');
                })
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

    public function scopegetKelas($query, $params)
    {
        return $query
            ->where('tgl', $params['tgl'])
            ->where('jadwal_id', $params['jadwal_id']);
    }

    public function scopegetGuru($query, $params)
    {
        return $query
            ->where('tgl', $params['tgl'])
            ->where('guru_id', $params['guru_id']);
    }

    public function scopegetJamKelas($query, $params)
    {
        return $query
            ->where('tgl', $params['tgl'])
            ->where('jadwal_id', $params['jadwal_id']);
    }

    public function scopetimeOnly($query, $params)
    {
        return $query
            ->where(function ($a) use ($params) {
                $a->where(function ($b) use ($params) {
                    $b
                        ->where('jam_masuk', $params['jam_keluar'])
                        ->orWhere('jam_keluar', $params['jam_masuk']);
                })
                    ->orWhere(function ($b) use ($params) {
                        $b
                            ->where('jam_masuk', '<=', $params['jam_masuk'])
                            ->where('jam_keluar', '>=', $params['jam_masuk']);
                    });
            });
    }
}
