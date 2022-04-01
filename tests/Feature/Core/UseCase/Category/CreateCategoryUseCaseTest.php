<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CreateCategoryInputDto;
use Core\UseCase\DTO\Category\CreateCategoryOutputDto;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{

    public function test_create_category_use_case()
    {
        $repository = new CategoryEloquentRepository(new Model());

        $input = new CreateCategoryInputDto(
            name: 'Category Test',
            description: 'Category description',
        );

        $useCase = new CreateCategoryUseCase($repository);
        $response = $useCase->execute($input);

        $this->assertInstanceOf(CreateCategoryOutputDto::class, $response);
        $this->assertNotEmpty($response->id);
        $this->assertEquals($input->name, $response->name);
        $this->assertEquals($input->description, $response->description);
        $this->assertTrue($response->is_active);

        $this->assertDatabaseHas(
            'categories',
            [
                'id' => $response->id,
                'name' => $response->name,
                'description' => $response->description
            ]
        );
    }
}
