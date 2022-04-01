<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\FindCategoryByIdUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CategoryOutputDto;
use Tests\TestCase;

class FindCategoryByIdUseCaseTest extends TestCase
{
    public function test_find_category_by_id_use_case()
    {
        $category = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new FindCategoryByIdUseCase($repository);

        $response = $useCase->execute(
            new CategoryInputDto(id: $category->id)
        );

        $this->assertInstanceOf(CategoryOutputDto::class, $response);
        $this->assertNotEmpty($response->id);
        $this->assertEquals($category->id, $response->id);
        $this->assertEquals($category->name, $response->name);
        $this->assertEquals($category->description, $response->description);
    }
}
