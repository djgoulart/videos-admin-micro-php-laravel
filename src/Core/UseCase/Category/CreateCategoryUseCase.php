<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\{
    CreateCategoryInputDto,
    CreateCategoryOutputDto
};

class CreateCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateCategoryInputDto $categoryInput): CreateCategoryOutputDto
    {
        $category = new Category(
            name: $categoryInput->name,
            description: $categoryInput->description,
            isActive: $categoryInput->isActive
        );

        $newCategory = $this->repository->insert($category);

        return new CreateCategoryOutputDto(
            id: $newCategory->id(),
            name: $newCategory->name,
            description: $newCategory->description,
            is_active: $newCategory->isActive,
            created_at: $newCategory->createdAt,
            updated_at: $newCategory->updatedAt,
        );
    }
}
