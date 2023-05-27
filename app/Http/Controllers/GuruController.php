<?php

namespace App\Http\Controllers;

use App\Interfaces\GuruInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    private GuruInterface $guruRepo;

    public function __construct(GuruInterface $guruRepo)
    {
        $this->guruRepo = $guruRepo;
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
        $data = $this->guruRepo->getPayload($meta);
        return response()->json($data, $data['code']);
    }


    public function getById($id): JsonResponse
    {
        $data = $this->guruRepo->getPayloadById($id);
        return response()->json($data, $data['code']);
    }


    public function upsertData(Request $payload): JsonResponse
    {
        $id = $payload->id | null;
        $payload = array(
            'nama' => $payload->nama,
            'nip' => $payload->nip,
            'mapel_id' => (int) $payload->mapel_id,
            'pangkat_id' => (int) $payload->pangkat_id,
            'jumlah_jam' => (int) $payload->jumlah_jam,
            'ket' => $payload->ket,
        );
        $data = $this->guruRepo->insertPayload($id, $payload);
        return response()->json($data, $data['code']);
    }

    public function deleteData($id): JsonResponse
    {
        $data = $this->guruRepo->deletePayload($id);
        return response()->json($data, $data['code']);
    }
}
