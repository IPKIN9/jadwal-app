<?php

namespace App\Http\Controllers;

use App\Interfaces\UserManageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
  private UserManageInterface $userRepo;

  public function __construct(UserManageInterface $userRepo)
  {
    $this->userRepo = $userRepo;
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
    $data = $this->userRepo->getPayload($meta);
    return response()->json($data, $data['code']);
  }

  public function upsertData(Request $payload): JsonResponse
  {
    $id = $payload->uuid ? $payload->uuid : null;

    $this->validate($payload, [
      'nama'     => 'required|min:2|max:150',
      'email'    => 'required|email|max:150',
      'password' => 'required|confirmed|min:5|max:50',
      'role'     => 'required|min:2|max:50',
    ]);

    $payload = array(
      'nama'     => $payload->nama,
      'email'    => $payload->email,
      'password' => $payload->password,
      'role'     => $payload->role,
    );
    $data = $this->userRepo->insertPayload($id, $payload);
    return response()->json($data, $data['code']);
  }

  public function getById($id): JsonResponse
  {
    $data = $this->userRepo->getPayloadById($id);
    return response()->json($data, $data['code']);
  }


  public function getByRoles(): JsonResponse
  {
    $username = request('username');
    $data = $this->userRepo->getRoles($username);
    return response()->json($data, $data['code']);
  }

  public function deleteData($id): JsonResponse
  {
    $data = $this->userRepo->deletePayload($id);
    return response()->json($data, $data['code']);
  }
}
