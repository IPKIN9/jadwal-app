<?php

namespace App\Interfaces;

interface MapelInterface
{
  public function getPayload($meta);
  public function insertPayload($id, array $payload);
  public function getPayloadById($id);
  public function deletePayload($id);
}
