<?php

namespace App\Http\Controllers;

use App\Interfaces\PangkatInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PangkatController extends Controller
{
  private PangkatInterface $pangkatRepo;

  public function __construct(PangkatInterface $pangkatRepo)
  {
    $this->pangkatRepo = $pangkatRepo;
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
    $data = $this->pangkatRepo->getPayload($meta);
    return response()->json($data, $data['code']);
  }

  public function upsertData(Request $payload): JsonResponse
  {
    $this->validate($payload, [
      '_pangkat' => 'required|min:2|max:150',
    ]);

    $id = $payload->id | null;
    $payload = array(
      '_pangkat' => $payload->_pangkat
    );
    $data = $this->pangkatRepo->insertPayload($id, $payload);
    return response()->json($data, $data['code']);
  }


  public function getById($id): JsonResponse
  {
    $data = $this->pangkatRepo->getPayloadById($id);
    return response()->json($data, $data['code']);
  }

  public function deleteData($id): JsonResponse
  {
    $data = $this->pangkatRepo->deletePayload($id);
    return response()->json($data, $data['code']);
  }
}
