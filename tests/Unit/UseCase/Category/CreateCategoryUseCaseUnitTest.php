<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\{
  CreateCategoryInputDto,
  CreateCategoryOutputDto,
};
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
  public function test_create_new_category()
  {
    $id = Uuid::uuid4()->toString();
    $categoryName = 'cat name';

    $this->mockEntity = Mockery::mock(Category::class, [
      $id,
      $categoryName,
    ]);

    $this->mockEntity->shouldReceive('id')->andReturn($id);

    $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
    $this->mockRepository->shouldReceive('insert')->andReturn($this->mockEntity);

    $this->mockInputDto = Mockery::mock(CreateCategoryInputDto::class, [
      $categoryName,
    ]);

    $useCase = new CreateCategoryUseCase($this->mockRepository);
    $useCaseResponse = $useCase->execute($this->mockInputDto);

    $this->assertInstanceOf(CreateCategoryOutputDto::class, $useCaseResponse);
    $this->assertNotEmpty($useCaseResponse->id);
    $this->assertEquals($id, $useCaseResponse->id);
    $this->assertEquals($categoryName, $useCaseResponse->name);
    $this->assertEquals('', $useCaseResponse->description);

    $this->spy = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
    $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);
    $useCase = new CreateCategoryUseCase($this->spy);
    $useCaseResponse = $useCase->execute($this->mockInputDto);
    $this->spy->shouldHaveReceived('insert');

    Mockery::close();
  }
}
