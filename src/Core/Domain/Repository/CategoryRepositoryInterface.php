<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function findAll(string $filter = '', string $orderColumn = 'id', string $order = 'DESC'): array;
    public function paginate(string $filter = '', string $orderColumn = 'id', string $order = 'DESC', int $page = 1, int $pageLimit = 15): PaginationInterface;
    public function findById(string $id): Category;
    public function insert(Category $category): Category;
    public function update(Category $category): Category;
    public function delete(string $id): bool;
    public function toCategory(object $data): Category;
}
