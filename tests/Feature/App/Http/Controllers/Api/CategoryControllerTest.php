<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Requests\{
    StoreCategoryRequest,
    UpdateCategoryRequest,
};
use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Exception\NotFoundException;
use Core\UseCase\Category\{
    CreateCategoryUseCase,
    DeleteCategoryUseCase,
    FindCategoryByIdUseCase,
    ListCategoriesUseCase,
    UpdateCategoryUseCase,
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected $repository;
    protected $controller;

    protected function setUp(): void
    {
        $this->repository = new CategoryEloquentRepository(
            new Category()
        );

        $this->controller = new CategoryController();

        parent::setUp();
    }

    public function test_index_method()
    {
        $useCase = new ListCategoriesUseCase($this->repository);

        $sut = $this->controller->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $sut);
        $this->assertIsObject($sut->resource);
        $this->assertInstanceOf(Collection::class, $sut->resource);
        $this->assertArrayHasKey('meta', $sut->additional);
    }

    public function test_store_method()
    {
        $useCase = new CreateCategoryUseCase($this->repository);

        $request = new StoreCategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'my category',
            'description' => 'category description'
        ]));

        $sut = $this->controller->store($request, $useCase);

        $this->assertInstanceOf(JsonResponse::class, $sut);
        $this->assertEquals(Response::HTTP_CREATED, $sut->status());
    }

    public function test_show_method()
    {
        $category = Category::factory()->create();
        $useCase = new FindCategoryByIdUseCase($this->repository);

        $sut = $this->controller->show(
            useCase: $useCase,
            id: $category->id
        );

        $this->assertInstanceOf(JsonResponse::class, $sut);
        $this->assertEquals(Response::HTTP_OK, $sut->status());
    }

    public function test_show_method_with_category_not_found()
    {
        try {
            $useCase = new FindCategoryByIdUseCase($this->repository);

            $this->controller->show(
                useCase: $useCase,
                id: 'fake_id'
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function test_update_method()
    {
        $category = Category::factory()->create();
        $useCase = new UpdateCategoryUseCase($this->repository);

        $request = new UpdateCategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Name updated',
        ]));

        $sut = $this->controller->update(request: $request, useCase: $useCase, id: $category->id);

        $this->assertInstanceOf(JsonResponse::class, $sut);
        $this->assertEquals(Response::HTTP_CREATED, $sut->status());
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Name updated'
        ]);
    }

    public function test_delete_method()
    {
        $category = Category::factory()->create();
        $useCase = new DeleteCategoryUseCase($this->repository);

        $sut = $this->controller->destroy(useCase: $useCase, id: $category->id);

        $this->assertInstanceOf(JsonResponse::class, $sut);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $sut->status());
        $this->assertSoftDeleted('categories', [
            'id' => $category->id
        ]);
    }
}
