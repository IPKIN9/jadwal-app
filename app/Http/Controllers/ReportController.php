<?php

namespace App\Http\Controllers;

use App\Interfaces\DetailJadwalInterface;
use App\Interfaces\KelasInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
	private KelasInterface $kelasRepo;
	private DetailJadwalInterface $detailRepo;

	public function __construct(KelasInterface $kelasRepo, DetailJadwalInterface $detailRepo)
	{
		$this->kelasRepo = $kelasRepo;
		$this->detailRepo = $detailRepo;
	}

	public function getJadwalReport(): JsonResponse
	{
		$search    = request('search') || '';
    $jurusanId = (int) request('jurusan_id') | null;
    $start     = request('start');
    $end       = request('end');
    $meta = array(
      'search'      =>  $search,
      'jurusan_id'  =>  $jurusanId,
      'page'        =>  (int) request('page') ,
      'limit'       =>  (int) request('limit'),
      'orderBy'     =>  request('orderBy'),
      'sort'        =>  request('sort'),
    );
		$kelas = $this->kelasRepo->getPayload($meta);
		// return response()->json($kelas);
		try {
			$report = array(
				'message' => '',
				'code'    => '',
				'kelas'   => []
			);
			
			foreach ($kelas['data'] as $key => $value) {
				$jadwalMeta = array(
					'kelas_id'   => $value['id'],
					'start_date' => $start,
					'end_date'   => $end,
				);
				$jadwal = $this->detailRepo->getPayload($jadwalMeta);
				array_push($report['kelas'], array(
					'nama_kelas' => $value['_kelas'],
					'data'  => $jadwal['data']
				));
			}
			return response()->json($report);

			$report['meta'] = array(
				'start' => $start,
				'end'   => $end,
				// 'total' => count($report['data'])
			);
			$report['message'] = 'Success';
			$report['code'] = 200;

		} catch (\Throwable $th) {

			$report['message'] = $th->getMessage();
			$report['code'] = 500;

		}

		return response()->json($report, $report['code']);
	}
}
