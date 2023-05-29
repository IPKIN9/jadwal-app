<?php

namespace App\Http\Controllers;

use App\Interfaces\MapelInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MapelController extends Controller
{
  private MapelInterface $mapelRepo;

  public function __construct(MapelInterface $mapelRepo)
  {
    $this->mapelRepo = $mapelRepo;
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
    $data = $this->mapelRepo->getPayload($meta);
    return response()->json($data, $data['code']);
  }


  public function getById($id): JsonResponse
  {
    $data = $this->mapelRepo->getPayloadById($id);
    return response()->json($data, $data['code']);
  }


  public function upsertData(Request $payload): JsonResponse
  {
    $this->validate($payload, [
      'nama_mapel' => 'required|min:2|max:150',
    ]);

    $id = $payload->id | null;
    $payload = array(
      'nama_mapel' => $payload->nama_mapel
    );
    $data = $this->mapelRepo->insertPayload($id, $payload);
    return response()->json($data, $data['code']);
  }

  public function deleteData($id): JsonResponse
  {
    $data = $this->mapelRepo->deletePayload($id);
    return response()->json($data, $data['code']);
  }
}
