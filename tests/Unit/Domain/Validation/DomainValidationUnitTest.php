<?php

namespace Tests\Unit\Domain\Validation;

use Throwable;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase
{
  public function test_notNull_validation()
  {
    try {
      DomainValidation::notNull('');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        "The value shouldn't be empty or null"
      );
    }
  }

  public function test_notNull_validation_with_custom_message()
  {
    try {
      DomainValidation::notNull('', 'Not null please');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        'Not null please'
      );
    }
  }

  public function test_strMaxLength_validation()
  {
    try {
      DomainValidation::strMaxLength('abc', 2);

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        "The value shouldn't have more than 2 characters"
      );
    }
  }

  public function test_strMaxLength_validation_with_custom_message()
  {
    try {
      DomainValidation::strMaxLength('abc', 2, 'Max 2 chars');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        'Max 2 chars'
      );
    }
  }

  public function test_strMinLength_validation_default()
  {
    try {
      DomainValidation::strMinLength('ab');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        "The value should have at least 3 characters"
      );
    }
  }

  public function test_strMinLength_validation_with_length_param()
  {
    try {
      DomainValidation::strMinLength('abc', 5);

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        "The value should have at least 5 characters"
      );
    }
  }

  public function test_strMinLength_validation_with_custom_message()
  {
    try {
      DomainValidation::strMinLength('abc', 5, 'Min 5 chars');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        'Min 5 chars'
      );
    }
  }

  public function test_strNullOrMaxLength_validation()
  {
    try {
      DomainValidation::strNullOrMaxLength('abc', 2);

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        "The value shouldn't have more than 2 characters"
      );
    }
  }

  public function test_strNullOrMaxLength_validation_with_null()
  {
    DomainValidation::strNullOrMaxLength('');
    $this->assertTrue(true);
  }

  public function test_strNullOrMaxLength_validation_with_custom_message()
  {
    try {
      DomainValidation::strNullOrMaxLength('abc', 2, 'Max 2 chars');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        'Max 2 chars'
      );
    }
  }

  public function test_strNullOrMinLength_validation_with_null()
  {
    DomainValidation::strNullOrMinLength('');
    $this->assertTrue(true);
  }

  public function test_strNullOrMinLength_validation()
  {
    try {
      DomainValidation::strNullOrMinLength('ab');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        "The value should have at least 3 characters"
      );
    }
  }

  public function test_strNullOrMinLength_validation_with_custom_value()
  {
    try {
      DomainValidation::strNullOrMinLength('abcd', 5);

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        "The value should have at least 5 characters"
      );
    }
  }

  public function test_strNullOrMinLength_validation_with_custom_message()
  {
    try {
      DomainValidation::strNullOrMinLength('abcd', 5, 'Min 5 chars');

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th,
        'Min 5 chars'
      );
    }
  }
}
