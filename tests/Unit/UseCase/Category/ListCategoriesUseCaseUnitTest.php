<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\{
    ListCategoriesInputDto,
    ListCategoriesOutputDto
};
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;


class ListCategoriesUseCaseUnitTest extends TestCase
{
    public function test_it_should_return_a_empty_list()
    {

        $mockPagination = $this->mockPagination();

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'desc']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('paginate')->andReturn($mockPagination);
        $useCase = new ListCategoriesUseCase($this->spy);
        $useCase->execute($this->mockInputDto);

        $this->spy->shouldHaveReceived('paginate');

        $this->assertCount(0, $useCaseResponse->items);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $useCaseResponse);
    }

    public function test_it_should_return_a_non_empty_list()
    {
        $register = new stdClass();
        $register->id = 'id';
        $register->name = 'name';
        $register->description = 'description';
        $register->is_active = 'is_active';
        $register->created_at = 'created_at';
        $register->updated_at = 'updated_at';
        $register->deleted_at = 'deleted_at';

        $mockPagination = $this->mockPagination([$register]);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'desc']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('paginate')->andReturn($mockPagination);
        $useCase = new ListCategoriesUseCase($this->spy);
        $useCase->execute($this->mockInputDto);

        $this->spy->shouldHaveReceived('paginate');

        $this->assertCount(1, $useCaseResponse->items);
        $this->assertInstanceOf(stdClass::class, $useCaseResponse->items[0]);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $useCaseResponse);
    }

    protected function mockPagination(array $items = [])
    {
        $this->mockPaginate = Mockery::mock(stdClass::class, PaginationInterface::class);
        $this->mockPaginate->shouldReceive('items')->andReturn($items);
        $this->mockPaginate->shouldReceive('total')->andReturn(0);
        $this->mockPaginate->shouldReceive('firstPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('currentPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('lastPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('perPage')->andReturn(0);
        $this->mockPaginate->shouldReceive('to')->andReturn(0);
        $this->mockPaginate->shouldReceive('from')->andReturn(0);

        return $this->mockPaginate;
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
