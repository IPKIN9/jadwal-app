<?php

namespace App\Repositories;

use App\Interfaces\GuruInterface;
use App\Models\GuruModel;
use Carbon\Carbon;

class GuruRepository implements GuruInterface
{

  private GuruModel $guruModel;

  public function __construct(GuruModel $guruModel)
  {
    $this->guruModel = $guruModel;
  }


  public function getPayload($meta)
  {
    try {
      $data = $this->guruModel->joinList()->pagginateList($meta)->sortered($meta)->get();
      $payloadList = array(
        'message' => 'success',
        'data'    => $data,
        'meta'    => array(
          'total'   => $this->guruModel->count(),
          'page'    => $meta['page'],
          'limit'   => $meta['limit'],
          'orderBy' => $meta['orderBy'],
          'sort' => $meta['sort'],
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
      $data = $this->guruModel->where('guru.id', $id)->joinList()->first();

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
        $data = $this->guruModel->create($payload);
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 201
        );
      } else {
        $payload['updated_at'] = Carbon::now();
        $data = $this->guruModel->whereId($id)->update($payload);
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
      $data = $this->guruModel->whereId($id)->count();

      if ($data >= 1) {
        $this->guruModel->whereId($id)->delete();
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
