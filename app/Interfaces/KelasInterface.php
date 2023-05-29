<?php

namespace App\Interfaces;

interface KelasInterface
{
  public function getPayload($meta);
  public function insertPayload($id, array $payload);
  public function getPayloadById($id);
  public function deletePayload($id);
}
