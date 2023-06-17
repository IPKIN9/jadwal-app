<?php

namespace App\Repositories;

use App\Interfaces\UserManageInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserManageRepository implements UserManageInterface
{

  private User $userModel;

  public function __construct(User $userModel)
  {
    $this->userModel = $userModel;
  }

  public function getPayload($meta)
  {
    try {
      $payloadList = array(
        'message' => 'success',
        'data'    => $this->userModel->pagginateList($meta)->get(),
        'meta'    => array(
          'total'   => $this->userModel->count(),
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

  public function insertPayload($id, array $payload)
  {
    try {
      $payload['password']   = Hash::make($payload['password']);
      $payload['updated_at'] = Carbon::now();
      if (!$id) {
        $payload['uuid']       = Uuid::uuid4()->toString();
        $payload['created_at'] = Carbon::now();

        $data = $this->userModel->create($payload);
        $payloadList = array(
          'message' => 'success',
          'data'    => $data,
          'code'    => 201
        );
      } else {
        $data = $this->userModel->where('uuid', $id)->update($payload);
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

  public function getPayloadById($id)
  {
    try {
      $data = $this->userModel->where('uuid', $id)->first();

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

  public function deletePayload($id)
  {
    try {
      $data = $this->userModel->where('uuid', $id)->count();

      if ($data >= 1) {
        $this->userModel->where('uuid', $id)->delete();
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
