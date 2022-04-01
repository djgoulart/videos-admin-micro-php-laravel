<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\DeleteCategoryInputDto;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_category_use_case()
    {
        $category = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new DeleteCategoryUseCase($repository);

        $response = $useCase->execute(
            new DeleteCategoryInputDto(
                id: $category->id
            )
        );

        $this->assertTrue($response->success);
        $this->assertSoftDeleted($category);
    }
}
