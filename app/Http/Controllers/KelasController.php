<?php

namespace App\Http\Controllers;

use App\Interfaces\KelasInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KelasController extends Controller
{
  private KelasInterface $kelasRepo;

  public function __construct(KelasInterface $kelasRepo)
  {
    $this->kelasRepo = $kelasRepo;
  }

  public function getAllData(): JsonResponse
  {
    $search    = request('search'  ) | '';
    $jurusanId = request('jurusan_id') | '';
    $meta = array(
      'search'      =>  $search,
      'jurusan_id'  =>  $jurusanId,
      'page'        =>  (int) request('page') ,
      'limit'       =>  (int) request('limit'),
      'orderBy'     =>  request('orderBy'),
      'sort'        =>  request('sort'),
    );
    $data = $this->kelasRepo->getPayload($meta);
    return response()->json($data, $data['code']);
  }


  public function getById($id): JsonResponse
  {
    $data = $this->kelasRepo->getPayloadById($id);
    return response()->json($data, $data['code']);
  }


  public function upsertData(Request $payload): JsonResponse
  {
    $rules = array(
      '_kelas' => 'required|min:2|max:150',
      'jurusan_id' => 'required|numeric',
    );

    $this->validate($payload, $rules);

    $id = $payload->id | null;
    $payload = array(
      '_kelas' => $payload->_kelas,
      'jurusan_id' => $payload->jurusan_id
    );
    $data = $this->kelasRepo->insertPayload($id, $payload);
    return response()->json($data, $data['code']);
  }

  public function deleteData($id): JsonResponse
  {
    $data = $this->kelasRepo->deletePayload($id);
    return response()->json($data, $data['code']);
  }
}
