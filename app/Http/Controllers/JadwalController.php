<?php

namespace App\Http\Controllers;

use App\Interfaces\JadwalInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
  private JadwalInterface $jadwalRepo;

  public function __construct(JadwalInterface $jadwalRepo)
  {
    $this->jadwalRepo = $jadwalRepo;
  }

  public function getAllData(): JsonResponse
  {
    $meta = array(
      'search' => request('search'),
      'page'   => (int) request('page'),
      'limit'  => (int) request('limit'),
      'orderBy'  => request('orderBy'),
      'sort'  => request('sort'),
    );
    $data = $this->jadwalRepo->getPayload($meta);
    return response()->json($data, $data['code']);
  }


  public function getById($id): JsonResponse
  {
    $data = $this->jadwalRepo->getPayloadById($id);
    return response()->json($data, $data['code']);
  }


  public function upsertData(Request $payload): JsonResponse
  {
    $rules = array(
      'kode' => 'required',
      'kelas_id' => 'required|numeric',
    );

    $this->validate($payload, $rules);

    $id = $payload->id | null;
    $payload = array(
      'kode' => $payload->kode,
      'kelas_id' => (int) $payload->kelas_id,
      'ket' => $payload->ket
    );
    $data = $this->jadwalRepo->insertPayload($id, $payload);
    return response()->json($data, $data['code']);
  }

  public function deleteData($id): JsonResponse
  {
    $data = $this->jadwalRepo->deletePayload($id);
    return response()->json($data, $data['code']);
  }
}
