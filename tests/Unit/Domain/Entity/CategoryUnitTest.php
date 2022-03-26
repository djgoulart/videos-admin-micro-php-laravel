<?php

namespace Tests\Unit\Domain\Entity;

use Throwable;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Ramsey\Uuid\Uuid;

class CategoryUnitTest extends TestCase
{
  public function test_should_get_attributes()
  {
    $category = new Category(
      name: 'name',
      description: 'description',
      isActive: true
    );

    $this->assertNotEmpty($category->id);
    $this->assertEquals('name', $category->name);
    $this->assertEquals('description', $category->description);
    $this->assertEquals(true, $category->isActive);
  }

  public function test_should_activate_the_category()
  {
    $category = new Category(
      name: 'name',
      description: 'description',
      isActive: false
    );

    $this->assertFalse($category->isActive);

    $category->activate();

    $this->assertTrue($category->isActive);
  }

  public function test_should_deactivate_the_category()
  {
    $category = new Category(
      name: 'name',
      description: 'description',
      isActive: true
    );

    $this->assertTrue($category->isActive);

    $category->disable();

    $this->assertFalse($category->isActive);
  }

  public function test_should_create_a_id()
  {
    $category = new Category(
      name: "category test"
    );

    $this->assertNotEmpty($category->id());
  }

  public function test_should_mantain_a_id()
  {
    $uuid = Uuid::uuid4()->toString();

    $category = new Category(
      id: $uuid,
      name: "category test"
    );

    $this->assertEquals($uuid, $category->id());
  }

  public function test_invalid_name_should_throw_a_exception()
  {
    try {
      $category = new Category(
        name: 'aa',
        description: 'description',
        isActive: true
      );

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th
      );
    }
  }

  public function test_description_with_invalid_maxLenght_should_throw_a_exception()
  {
    try {
      $category = new Category(
        name: 'name',
        description: random_bytes(9999999),
        isActive: true
      );

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th
      );
    }
  }

  public function test_description_with_invalid_minLenght_should_throw_a_exception()
  {
    try {
      $category = new Category(
        name: 'name',
        description: 'ab',
        isActive: true
      );

      $this->assertTrue(false);
    } catch (Throwable $th) {
      $this->assertInstanceOf(
        EntityValidationException::class,
        $th
      );
    }
  }

  public function test_should_update_the_category()
  {
    $uuid = Uuid::uuid4()->toString();

    $category = new Category(
      id: $uuid,
      name: 'name',
      description: 'description',
      isActive: true
    );

    $category->update(
      name: 'name updated',
      description: 'description updated'
    );

    $this->assertEquals($uuid, $category->id());
    $this->assertEquals('name updated', $category->name);
    $this->assertEquals('description updated', $category->description);
  }

  public function test_should_update_only_the_category_name()
  {
    $uuid = Uuid::uuid4()->toString();

    $category = new Category(
      id: $uuid,
      name: 'name',
      description: 'description',
      isActive: true
    );

    $category->update(
      name: 'name updated'
    );

    $this->assertEquals($uuid, $category->id());
    $this->assertEquals('name updated', $category->name);
    $this->assertEquals('description', $category->description);
  }
}
