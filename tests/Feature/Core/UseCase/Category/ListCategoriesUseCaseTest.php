<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategoriesOutputDto;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    public function test_list_categories_without_items()
    {
        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new ListCategoriesUseCase($repository);

        $result = $useCase->execute(
            new ListCategoriesInputDto()
        );

        $this->assertCount(0, $result->items);
        $this->assertEquals(0, $result->total);
        $this->assertEquals(0, $result->first_page);
        $this->assertEquals(1, $result->current_page);
        $this->assertEquals(1, $result->last_page);
        $this->assertEquals(15, $result->per_page);
        $this->assertEquals(0, $result->from);
        $this->assertEquals(0, $result->to);
    }
    public function test_list_categories_use_case_without_filters()
    {
        Model::factory()->count(16)->create();
        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new ListCategoriesUseCase($repository);

        $result = $useCase->execute(
            new ListCategoriesInputDto()
        );

        $this->assertInstanceOf(ListCategoriesOutputDto::class, $result);

        $this->assertObjectHasAttribute('items', $result);
        $this->assertIsArray($result->items);
        $this->assertCount(15, $result->items);

        $this->assertObjectHasAttribute('total', $result);
        $this->assertIsInt($result->total);
        $this->assertEquals(16, $result->total);

        $this->assertObjectHasAttribute('first_page', $result);
        $this->assertIsInt($result->first_page);
        $this->assertEquals(1, $result->first_page);

        $this->assertObjectHasAttribute('current_page', $result);
        $this->assertIsInt($result->current_page);
        $this->assertEquals(1, $result->current_page);

        $this->assertObjectHasAttribute('last_page', $result);
        $this->assertIsInt($result->last_page);
        $this->assertEquals(2, $result->last_page);

        $this->assertObjectHasAttribute('per_page', $result);
        $this->assertIsInt($result->per_page);
        $this->assertEquals(15, $result->per_page);

        $this->assertObjectHasAttribute('from', $result);
        $this->assertIsInt($result->from);
        $this->assertEquals(1, $result->from);

        $this->assertObjectHasAttribute('to', $result);
        $this->assertIsInt($result->to);
        $this->assertEquals(15, $result->to);
    }
}
