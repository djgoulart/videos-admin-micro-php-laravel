<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\FindCategoryByIdUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class FindCategoryByIdUseCaseUnitTest extends TestCase
{
    public function test_getById()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'cat name';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id,
            $categoryName,
        ]);

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')
            ->once()
            ->with($id)
            ->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [$id,]);

        $useCase = new FindCategoryByIdUseCase($this->mockRepository);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryOutputDto::class, $useCaseResponse);
        $this->assertEquals($categoryName, $useCaseResponse->name);
        $this->assertEquals($id, $useCaseResponse->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
