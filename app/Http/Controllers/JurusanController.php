<?php

namespace App\Http\Controllers;

use App\Interfaces\JurusanInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
  private JurusanInterface $jurusanRepo;

  public function __construct(JurusanInterface $jurusanRepo)
  {
    $this->jurusanRepo = $jurusanRepo;
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
    $data = $this->jurusanRepo->getPayload($meta);
    return response()->json($data, $data['code']);
  }

  public function upsertData(Request $payload): JsonResponse
  {
    $this->validate($payload, [
      '_jurusan' => 'required|min:2|max:150',
    ]);

    $id = $payload->id | null;
    $payload = array(
      '_jurusan' => $payload->_jurusan
    );
    $data = $this->jurusanRepo->insertPayload($id, $payload);
    return response()->json($data, $data['code']);
  }

  public function getById($id): JsonResponse
  {
    $data = $this->jurusanRepo->getPayloadById($id);
    return response()->json($data, $data['code']);
  }

  public function deleteData($id): JsonResponse
  {
    $data = $this->jurusanRepo->deletePayload($id);
    return response()->json($data, $data['code']);
  }
}
