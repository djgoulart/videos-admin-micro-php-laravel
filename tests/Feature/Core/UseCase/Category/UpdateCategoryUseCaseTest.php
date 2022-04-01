<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\UpdateCategoryInputDto;
use Tests\TestCase;

class UpdateCategoryUseCaseTest extends TestCase
{
    public function test_update_category_use_case_partial_update()
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new UpdateCategoryUseCase($repository);

        $result = $useCase->execute(
            new UpdateCategoryInputDto(
                id: $categoryDb->id,
                name: 'updated name',
            )
        );

        $this->assertNotEquals($categoryDb->name, $result->name);
        $this->assertEquals($categoryDb->id, $result->id);
        $this->assertEquals('updated name', $result->name);
        $this->assertEquals($categoryDb->description, $result->description);
        $this->assertTrue($result->is_active);

        $this->assertDatabaseHas('categories', [
            'name' => $result->name
        ]);
    }

    public function test_update_category_use_case()
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new UpdateCategoryUseCase($repository);

        $result = $useCase->execute(
            new UpdateCategoryInputDto(
                id: $categoryDb->id,
                name: 'updated name',
                description: 'updated description',
            )
        );

        $this->assertNotEquals($categoryDb->name, $result->name);
        $this->assertEquals($categoryDb->id, $result->id);
        $this->assertEquals('updated name', $result->name);
        $this->assertEquals('updated description', $result->description);
        $this->assertTrue($result->is_active);

        $this->assertDatabaseHas('categories', [
            'name' => 'updated name',
            'description' => 'updated description',
        ]);
    }
}
