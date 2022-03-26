<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\DeleteCategoryInputDto;
use Core\UseCase\DTO\Category\DeleteCategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteCategoryUseCaseUnitTest extends TestCase
{
    public function test_it_should_delete_a_category()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'category';
        $categoryDesc = 'desc';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id, $categoryName, $categoryDesc
        ]);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('delete')->andReturn(true);

        $this->mockInputDto = Mockery::mock(DeleteCategoryInputDto::class, [
            $id
        ]);

        $useCase = new DeleteCategoryUseCase($this->mockRepo);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(DeleteCategoryOutputDto::class, $useCaseResponse);
        $this->assertTrue($useCaseResponse->success);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('delete')->andReturn(true);

        $useCase = new DeleteCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDto);

        $this->spy->shouldHaveReceived('delete');
    }

    public function test_if_fail_to_delete_a_category()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'category';
        $categoryDesc = 'desc';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id, $categoryName, $categoryDesc
        ]);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('delete')->andReturn(false);

        $this->mockInputDto = Mockery::mock(DeleteCategoryInputDto::class, [
            $id
        ]);

        $useCase = new DeleteCategoryUseCase($this->mockRepo);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(DeleteCategoryOutputDto::class, $useCaseResponse);
        $this->assertFalse($useCaseResponse->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
