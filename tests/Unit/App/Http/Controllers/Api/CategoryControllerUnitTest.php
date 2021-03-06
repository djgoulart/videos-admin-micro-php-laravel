<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategoriesOutputDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class CategoryControllerUnitTest extends TestCase
{
    public function test_index_method()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')->andReturn('test');

        $mockOutputDto = Mockery::mock(ListCategoriesOutputDto::class, [
            [], 1, 1, 1, 1, 1, 1, 1
        ]);

        $mockUseCase = Mockery::mock(ListCategoriesUseCase::class);
        $mockUseCase->shouldReceive('execute')->once()->andReturn($mockOutputDto);

        $controller = new CategoryController($mockRequest);
        $response = $controller->index($mockRequest, $mockUseCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertIsObject($response->resource);
        $this->assertInstanceOf(Collection::class, $response->resource);
        $this->assertArrayHasKey('meta', $response->additional);

        Mockery::close();
    }
}
