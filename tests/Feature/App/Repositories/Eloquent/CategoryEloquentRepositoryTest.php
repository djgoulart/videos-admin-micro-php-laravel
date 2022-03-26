<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Entity\Category as CategoryEntity;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
