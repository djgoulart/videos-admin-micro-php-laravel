<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Entity\Category as CategoryEntity;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PhpParser\Node\Stmt\TryCatch;
use Tests\TestCase;
use Throwable;

class CategoryEloquentRepositoryTest extends TestCase
{

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new CategoryEloquentRepository(new Model());
    }


    public function test_it_should_persist_a_category_on_database()
    {
        $entity = new CategoryEntity(
            name: 'Test Category'
        );

        $category = $this->repository->insert($entity);

        $this->assertInstanceOf(CategoryRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(CategoryEntity::class, $category);
        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
        ]);
    }

    public function test_it_should_find_a_category_searching_by_a_given_id()
    {
        $category = Model::factory()->create();
        $response = $this->repository->findById($category->id);

        $this->assertInstanceOf(CategoryEntity::class, $response);
        $this->assertEquals($category->id, $response->id());
        $this->assertEquals($category->name, $response->name);
        $this->assertEquals($category->description, $response->description);
        $this->assertEquals($category->is_active, $response->isActive);
    }

    public function test_it_should_throw_if_not_found_a_category_searching_by_id()
    {
        try {
            $this->repository->findById('fakeID');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function test_it_should_find_all_categories()
    {
        $categories = Model::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertCount(count($categories), $response);
    }

    public function test_it_should_paginate_categories()
    {
        $pageLimit = 15;
        $categories = Model::factory()->count(20)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount($pageLimit, $response->items());
        $this->assertEquals(count($categories), $response->total());
    }

    public function test_it_should_paginate_categories_without_data()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
        $this->assertEquals(0, $response->total());
    }
}
