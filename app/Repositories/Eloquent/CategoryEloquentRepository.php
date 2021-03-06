<?php

namespace App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Category;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;

class CategoryEloquentRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Model $category)
    {
        $this->model = $category;
    }

    public function findAll(
        string $filter = '',
        string $orderColumn = 'id',
        string $order = 'DESC'
    ): array {
        $categories = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter)
                    $query->where('name', 'LIKE', "%{$filter}%");
            })
            ->orderBy('id', $order)
            ->get();

        return $categories->toArray();
    }

    public function paginate(string $filter = '', string $orderColumn = 'id', string $order = 'DESC', int $page = 1, int $pageLimit = 15): PaginationInterface
    {
        $query = $this->model;
        if ($filter) {
            $query->where('name', 'LIKE', "%{$filter}%");
        }
        $query->orderBy('id', $order);
        $paginator = $query->paginate($pageLimit);

        return new PaginationPresenter($paginator);
    }

    public function findById(string $id): Category
    {
        if (!$category = $this->model->find($id)) {
            throw new NotFoundException();
        }

        return $this->toCategory($category);
    }

    public function insert(Category $category): Category
    {
        $category = $this->model->create([
            'id' => $category->id(),
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
        ]);

        return $this->toCategory($category);
    }

    public function update(Category $category): Category
    {
        if (!$categoryDb = $this->model->find($category->id())) {
            throw new NotFoundException("Category with id {$category->id()} not found");
        }

        $categoryDb->update([
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive
        ]);

        $categoryDb->refresh();

        return $this->toCategory($categoryDb);
    }

    public function delete(string $id): bool
    {
        if (!$category = $this->model->find($id)) {
            throw new NotFoundException("Category with id {$id} not found");
        }

        $category->delete();
        return true;
    }

    public function toCategory(object $object): Category
    {
        return new Category(
            id: $object->id,
            name: $object->name,
            description: $object->description,
            isActive: (bool) $object->is_active,
            createdAt: $object->created_at,
            updatedAt: $object->updated_at,
        );
    }
}
