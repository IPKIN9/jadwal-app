<?php

namespace App\Repositories;

use App\Interfaces\PangkatInterface;
use App\Models\PangkatModel;
use Carbon\Carbon;

class PangkatRepository implements PangkatInterface
{
  private PangkatModel $PangkatModel;

  public function __construct(PangkatModel $PangkatModel)
  {
    $this->PangkatModel = $PangkatModel;
  }

  public function getPayload($meta)
  {
    try {
      $data = $this->PangkatModel->pagginateList($meta)->sortered($meta)->get();
      $payloadList = array(
        'message' => 'success',
        'data'    => $data,
        'meta'    => array(
          'total'         => $this->PangkatModel->count(),
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
      $data = $this->PangkatModel->whereId($id)->first();

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
        $data = $this->PangkatModel->create($payload);
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 201
        );
      } else {
        $payload['updated_at'] = Carbon::now();
        $data = $this->PangkatModel->whereId($id)->update($payload);
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
      $data = $this->PangkatModel->whereId($id)->count();

      if ($data >= 1) {
        $this->PangkatModel->whereId($id)->delete();
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
