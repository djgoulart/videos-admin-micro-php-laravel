<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\{
    CategoryInputDto,
    CategoryOutputDto
};

class FindCategoryByIdUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryInputDto $imput): CategoryOutputDto
    {
        $category = $this->repository->findById($imput->id);

        return new CategoryOutputDto(
            id: $category->id,
            name: $category->name,
            description: $category->description,
            is_active: $category->isActive,
            created_at: $category->createdAt,
            updated_at: $category->updatedAt,
        );
    }
}
