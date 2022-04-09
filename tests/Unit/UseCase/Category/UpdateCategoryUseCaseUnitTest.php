<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\UpdateCategoryInputDto;
use Core\UseCase\DTO\Category\UpdateCategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateCategoryUseCaseUnitTest extends TestCase
{

    public function test_it_should_update_a_category()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'category';
        $categoryDesc = 'desc';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id, $categoryName, $categoryDesc
        ]);

        $this->mockEntity->shouldReceive('update')->once();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')->once()->andReturn($this->mockEntity);
        $this->mockRepository->shouldReceive('update')->once()->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(UpdateCategoryInputDto::class, [
            $id,
            'new name'
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepository);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(UpdateCategoryOutputDto::class, $useCaseResponse);

        Mockery::close();
    }
}
