<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\{
    CreateCategoryUseCase,
    DeleteCategoryUseCase,
    FindCategoryByIdUseCase,
    ListCategoriesUseCase,
    UpdateCategoryUseCase
};
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CreateCategoryInputDto;
use Core\UseCase\DTO\Category\DeleteCategoryInputDto;
use Core\UseCase\DTO\Category\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\UpdateCategoryInputDto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategoriesUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new ListCategoriesInputDto(
                filter: $request->get('filter', ''),
                orderColumn: $request->get('orderColumn', 'id'),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                pageLimit: (int) $request->get('pageLimit', 15),
            )
        );

        return CategoryResource::collection(collect($response->items))
            ->additional([
                'meta' => [
                    'total' => $response->total,
                    'first_page' => $response->first_page,
                    'current_page' => $response->current_page,
                    'last_page' => $response->last_page,
                    'per_page' => $response->per_page,
                    'to' => $response->to,
                    'from' => $response->from,
                ]
            ]);
    }

    public function show(FindCategoryByIdUseCase $useCase, string $id)
    {
        $category = $useCase->execute(
            new CategoryInputDto(id: $id)
        );

        return (new CategoryResource(collect($category)))
            ->response();
    }

    public function store(StoreCategoryRequest $request, CreateCategoryUseCase $useCase)
    {
        $response = $useCase->execute(
            new CreateCategoryInputDto(
                name: $request->name,
                description: $request->description ?? '',
                isActive: (bool) $request->is_active ?? true,
            )
        );

        return (new CategoryResource(collect($response)))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateCategoryRequest $request, UpdateCategoryUseCase $useCase, string $id)
    {
        $model = new Category();
        $repository = new CategoryEloquentRepository($model);
        $findCategoryUseCase = new FindCategoryByIdUseCase($repository);
        $category = $findCategoryUseCase->execute(new CategoryInputDto($id));

        $updatedCategory = $useCase->execute(new UpdateCategoryInputDto(
            id: $id,
            name: $request->name,
            description: $request->description ?? $category->description
        ));

        return (new CategoryResource(collect($updatedCategory)))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(DeleteCategoryUseCase $useCase, string $id)
    {
        $model = new Category();
        $repository = new CategoryEloquentRepository($model);
        $findCategoryUseCase = new FindCategoryByIdUseCase($repository);
        $findCategoryUseCase->execute(new CategoryInputDto($id));

        $deletedCategory = $useCase->execute(new DeleteCategoryInputDto(id: $id));
        return (new CategoryResource(collect($deletedCategory)))
            ->response()
            ->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
