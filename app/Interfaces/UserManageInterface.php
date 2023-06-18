<?php

namespace App\Interfaces;

interface UserManageInterface
{
  public function getPayload($meta);
  public function getRoles($username);
  public function insertPayload($id, array $payload);
  public function getPayloadById($id);
  public function deletePayload($id);
}
