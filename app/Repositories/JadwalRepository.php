<?php

namespace App\Repositories;

use App\Interfaces\JadwalInterface;
use App\Models\JadwalModel;
use Carbon\Carbon;

class JadwalRepository implements JadwalInterface
{

  private JadwalModel $jadwalModel;

  public function __construct(JadwalModel $jadwalModel)
  {
    $this->jadwalModel = $jadwalModel;
  }


  public function getPayload($meta)
  {
    try {
      $data = $this->jadwalModel->joinList()->pagginateList($meta)->sortered($meta)->get();
      $payloadList = array(
        'message' => 'success',
        'data'    => $data,
        'meta'    => array(
          'total'         => $this->jadwalModel->count(),
          'page'          => $meta['page'],
          'limit'         => $meta['limit'],
          'orderBy'       => $meta['orderBy'],
          'sort'          => $meta['sort'],
          'total_in_page' => $data->count()
        ),
        'code'    => 200
      );
    } catch (\Throwable $th) {
      $payloadList = array(
        'message' => $th->getMessage(),
        'code'    => 500
      );
    }

    return $payloadList;
  }

  public function getPayloadById($id)
  {
    try {
      $data = $this->jadwalModel->where('jadwal.id', $id)->joinList()->first();

      if ($data) {
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 200
        );
      } else {
        $payloadList = array(
          'message' => 'not found',
          'data'    => null,
          'code'    => 404
        );
      }
    } catch (\Throwable $th) {
      $payloadList = array(
        'message' => $th->getMessage(),
        'code'    => 500
      );
    }

    return $payloadList;
  }

  public function insertPayload($id, array $payload)
  {
    try {
      if (!$id) {
        $payload['created_at'] = Carbon::now();
        $payload['updated_at'] = Carbon::now();
        $data = $this->jadwalModel->create($payload);
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 201
        );
      } else {
        $payload['updated_at'] = Carbon::now();
        $data = $this->jadwalModel->whereId($id)->update($payload);
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 201
        );
      }
    } catch (\Throwable $th) {
      $payloadList = array(
        'message' => $th->getMessage(),
        'code'    => 500
      );
    }

    return $payloadList;
  }

  public function deletePayload($id)
  {
    try {
      $data = $this->jadwalModel->whereId($id)->count();

      if ($data >= 1) {
        $this->jadwalModel->whereId($id)->delete();
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 200
        );
      } else {
        $payloadList = array(
          'message' => 'not found',
          'data'    => null,
          'code'    => 404
        );
      }
    } catch (\Throwable $th) {
      $payloadList = array(
        'message' => $th->getMessage(),
        'code'    => 500
      );
    }

    return $payloadList;
  }
}
