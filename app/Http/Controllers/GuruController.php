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
        $rules = array(
            'nama' => 'required|min:2|max:150',
            'nip' => 'required|min:15|max:20',
            'mapel_id' => 'required|numeric',
            'pangkat_id' => 'required|numeric',
            'jumlah_jam' => 'required|numeric',
        );

        $this->validate($payload, $rules);

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
