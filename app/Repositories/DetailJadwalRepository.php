<?php

namespace App\Repositories;

use App\Interfaces\DetailJadwalInterface;
use App\Models\DetailJadwalModel;
use Carbon\Carbon;

class DetailJadwalRepository implements DetailJadwalInterface
{
  private DetailJadwalModel $detailJadwalModel;

  public function __construct(DetailJadwalModel $detailJadwalModel)
  {
    $this->detailJadwalModel = $detailJadwalModel;
  }


  public function getPayload($meta)
  {
    try {
      $data = $this->detailJadwalModel->pagginateList($meta)->joinList();
      $payloadList = array(
        'message' => 'success',
        'data'    => $data->get(),
        'meta'    => array(
          'total'   => $data->count(),
          'page'    => $meta['page'],
          'limit'   => $meta['limit'],
          'orderBy' => $meta['orderBy'],
          'sort' => $meta['sort'],
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
      $data = $this->detailJadwalModel->where('detail_jadwal.id', $id)->joinList()->first();

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
        $data = $this->detailJadwalModel->create($payload);
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 201
        );
      } else {
        $payload['updated_at'] = Carbon::now();
        $data = $this->detailJadwalModel->whereId($id)->update($payload);
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

  public function scanningPayload($meta)
  {
    try {
      $data   = $this->detailJadwalModel;
      $kelas  = $data->getKelas($meta)->count();
      $guru   = $data->getGuru($meta)->count();
      $time   = $data->getJam($meta)->count();

      $payloadList = array(
        'message' => 'success',
        'static'  => array(
          'kelas'   => $kelas >= 2 ? 'full' : $kelas,
          'guru'    => $guru >= 2 ? 'full' : $guru,
          'time'    => $time >= 1 ? 'full' : 1,
        ),
        'ready'   => $guru < 2 & $kelas < 2 and $time < 1 ? true : false,
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

  public function deletePayload($id)
  {
    try {
      $data = $this->detailJadwalModel->whereId($id)->count();

      if ($data >= 1) {
        $this->detailJadwalModel->whereId($id)->delete();
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
