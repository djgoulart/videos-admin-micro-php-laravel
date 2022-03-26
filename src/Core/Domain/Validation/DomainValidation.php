<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
  public static function notNull(string $value, string $exceptionMessage = null)
  {
    if (empty($value))
      throw new EntityValidationException(
        $exceptionMessage ?? "The value shouldn't be empty or null"
      );
  }

  public static function strMaxLength(
    string $value,
    int $length = 255,
    string $exceptionMessage = null
  ) {

    if (strlen($value) > $length)
      throw new EntityValidationException(
        $exceptionMessage ??
          "The value shouldn't have more than {$length} characters"
      );
  }

  public static function strMinLength(
    string $value,
    int $length = 3,
    string $exceptionMessage = null
  ) {

    if (strlen($value) < $length)
      throw new EntityValidationException(
        $exceptionMessage ??
          "The value should have at least {$length} characters"
      );
  }

  public static function strNullOrMaxLength(
    string $value,
    int $length = 255,
    string $exceptionMessage = null
  ) {

    if (!empty($value) && strlen($value) > $length)
      throw new EntityValidationException(
        $exceptionMessage ??
          "The value shouldn't have more than {$length} characters"
      );
  }

  public static function strNullOrMinLength(
    string $value,
    int $length = 3,
    string $exceptionMessage = null
  ) {

    if (!empty($value) && strlen($value) < $length)
      throw new EntityValidationException(
        $exceptionMessage ??
          "The value should have at least {$length} characters"
      );
  }
}
