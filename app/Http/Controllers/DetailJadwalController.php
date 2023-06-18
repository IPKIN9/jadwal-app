<?php

namespace App\Http\Controllers;

use App\Interfaces\DetailJadwalInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DetailJadwalController extends Controller
{
  private DetailJadwalInterface $detailJadwalRepo;

  public function __construct(DetailJadwalInterface $detailJadwalRepo)
  {
    $this->detailJadwalRepo = $detailJadwalRepo;
  }

  public function getAllData(): JsonResponse
  {
    $meta = array(
      'kelas_id'  => request('kelas_id'),
      'start_date' => request('start_date'),
      'end_date'   => request('end_date'),
    );
    $data = $this->detailJadwalRepo->getPayload($meta);
    return response()->json($data, $data['code']);
  }


  public function getById($id): JsonResponse
  {
    $data = $this->detailJadwalRepo->getPayloadById($id);
    return response()->json($data, $data['code']);
  }


  public function upsertData(Request $payload): JsonResponse
  {
    $rules = array(
      'kelas_id' => 'required|numeric',
      'guru_id' => 'required|numeric',
      'mapel' => 'required|min:2|max:150',
      'jumlah_jam' => 'required|numeric',
      'tgl' => 'required',
      'jam_masuk' => 'required',
      'jam_keluar' => 'required',
    );

    $this->validate($payload, $rules);

    $id = $payload->id | null;
    $payload = array(
      'kelas_id'  => (int) $payload->kelas_id,
      'guru_id'    => (int) $payload->guru_id,
      'mapel'      =>       $payload->mapel,
      'jumlah_jam' => (int) $payload->jumlah_jam,
      'tgl'        =>       $payload->tgl,
      'jam_masuk'  =>       $payload->jam_masuk,
      'jam_keluar' =>       $payload->jam_keluar,
    );

    $scanResult = $this->detailJadwalRepo->scanningPayload($payload);

    if ((!$scanResult['ready']) & ($id == null)) {
      $data = array(
        'message' => 'conflict',
        'code'    => 409
      );
    } else {
      $data = $this->detailJadwalRepo->insertPayload($id, $payload);
    }

    return response()->json($data, $data['code']);
  }

  public function scanningData(): JsonResponse
  {
    $meta = array(
      'kelas_id'  => (int) request('kelas_id'),
      'guru_id'    => (int) request('guru_id'),
      'mapel'      =>       request('mapel'),
      'tgl'        =>       request('tgl'),
      'jam_masuk'  =>       request('jam_masuk'),
      'jam_keluar' =>       request('jam_keluar'),
    );
    $data = $this->detailJadwalRepo->scanningPayload($meta);
    return response()->json($data, $data['code']);
  }

  public function deleteData($id): JsonResponse
  {
    $data = $this->detailJadwalRepo->deletePayload($id);
    return response()->json($data, $data['code']);
  }
}
