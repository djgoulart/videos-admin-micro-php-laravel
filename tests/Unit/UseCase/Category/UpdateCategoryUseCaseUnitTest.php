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

        $this->mockEntity->shouldReceive('update');

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepository->shouldReceive('update')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(UpdateCategoryInputDto::class, [
            $id,
            'new name'
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepository);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(UpdateCategoryOutputDto::class, $useCaseResponse);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);

        $useCase = new UpdateCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDto);

        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');

        Mockery::close();
    }
}
