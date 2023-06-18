<?php

namespace App\Interfaces;

interface DetailJadwalInterface
{
  public function getPayload($meta);
  public function insertPayload($id, array $payload);
  public function getPayloadById($id);
  public function scanningPayload($id);
  public function deletePayload($id);
}
