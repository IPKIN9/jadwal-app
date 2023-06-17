<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailJadwalModel extends Model
{
	protected $table = 'detail_jadwal';

	protected $fillable = [
		'id', 'kelas_id', 'guru_id', 'mapel', 'jumlah_jam', 'tgl', 'jam_masuk', 'jam_keluar',
		'created_at', 'updated_at'
	];

	public function scopejoinList($query)
	{
		return $query
			->leftJoin('kelas as model_a', 'detail_jadwal.kelas_id', '=', 'model_a.id')
			->leftJoin('guru as model_b', 'detail_jadwal.guru_id', '=', 'model_b.id')
			->select(
				'detail_jadwal.id',
				'model_a._kelas as kelas',
				'detail_jadwal.kelas_id',
				'model_b.nama as guru',
				'detail_jadwal.guru_id',
				'detail_jadwal.mapel',
				'detail_jadwal.jumlah_jam',
				'detail_jadwal.tgl',
				'detail_jadwal.jam_masuk',
				'detail_jadwal.jam_keluar',
				'detail_jadwal.created_at',
				'detail_jadwal.updated_at',
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
		if (strlen($params['search']) >= 1 || $params['kelas_id'] | strlen($params['search']) >= 1) {
			return $query
				->where('kelas_id', $params['kelas_id'])
				->where(function ($q) use ($params) {
					$q->where('kode', 'LIKE', '%' . $params['search'] . '%')
						->orWhere('model_b.nama', 'LIKE', '%' . $params['search'] . '%')
						->orWhere('mapel', 'LIKE', '%' . $params['search'] . '%');
				});
		} else {
			return $query
				->offset($page)
				->limit($params['limit']);
		}
	}

	public function scopegetKelas($query, $params)
	{
		return $query
			->where('tgl', $params['tgl'])
			->where('kelas_id', $params['kelas_id']);
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
			->where('kelas_id', $params['kelas_id']);
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

	public function scopegetByMonth($query, $params)
	{
		if (strlen($params['kelas_id'] >= 1)) {
			return $query
			->where('kelas_id', $params['kelas_id'])
			->whereBetween('tgl', [$params['start_date'], $params['end_date']]);
		} else {
			return $query
			->whereBetween('tgl', [$params['start_date'], $params['end_date']]);
		}
	}
}
