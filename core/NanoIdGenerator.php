<?php

namespace Core;

use Exception;

class NanoIdGenerator
{
  private const PUBLIC_ID_ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyz';
  private const PUBLIC_ID_LENGTH = 12;
  private const MAX_RETRY = 1000;

  public static function generateNanoId(string $alphabet = self::PUBLIC_ID_ALPHABET, int $size = self::PUBLIC_ID_LENGTH): string
  {
    $id = '';
    $alphabetLength = strlen($alphabet);

    for ($i = 0; $i < $size; $i++) {
      $randomIndex = random_int(0, $alphabetLength - 1);
      $id .= $alphabet[$randomIndex];
    }

    return $id;
  }

  public static function generateUniqueId(callable $isUniqueCallback): string
  {
    for ($attempt = 0; $attempt < self::MAX_RETRY; $attempt++) {
      $id = self::generateNanoId();
      // dd($id);
      if ($isUniqueCallback($id)) {
        return $id;
      }
    }

    throw new Exception('Failed to generate a unique public ID after ' . self::MAX_RETRY . ' attempts.');
  }
}
