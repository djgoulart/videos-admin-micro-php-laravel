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
        $this->mockRepo->shouldReceive('paginate')
            ->once()
            ->andReturn($mockPagination);

        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'desc']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

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
        $this->mockRepo->shouldReceive('paginate')
            ->once()
            ->andReturn($mockPagination);

        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'desc']);

        $useCase = new ListCategoriesUseCase($this->mockRepo);
        $useCaseResponse = $useCase->execute($this->mockInputDto);

        $this->assertCount(1, $useCaseResponse->items);
        $this->assertInstanceOf(stdClass::class, $useCaseResponse->items[0]);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $useCaseResponse);
    }

    protected function mockPagination(array $items = [])
    {
        $this->mockPaginate = Mockery::mock(stdClass::class, PaginationInterface::class);
        $this->mockPaginate->shouldReceive('items')->once()->andReturn($items);
        $this->mockPaginate->shouldReceive('total')->once()->andReturn(0);
        $this->mockPaginate->shouldReceive('firstPage')->once()->andReturn(0);
        $this->mockPaginate->shouldReceive('currentPage')->once()->andReturn(0);
        $this->mockPaginate->shouldReceive('lastPage')->once()->andReturn(0);
        $this->mockPaginate->shouldReceive('perPage')->once()->andReturn(0);
        $this->mockPaginate->shouldReceive('to')->once()->andReturn(0);
        $this->mockPaginate->shouldReceive('from')->once()->andReturn(0);

        return $this->mockPaginate;
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
