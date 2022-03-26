<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\{
    UpdateCategoryInputDto,
    UpdateCategoryOutputDto
};

class UpdateCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UpdateCategoryInputDto $categoryInput): UpdateCategoryOutputDto
    {
        $category = $this->repository->findById($categoryInput->id);

        $category->update(
            name: $categoryInput->name,
            description: $categoryInput->description ?? $category->description,
        );

        $updatedCategory = $this->repository->update($category);

        return new UpdateCategoryOutputDto(
            id: $updatedCategory->id,
            name: $updatedCategory->name,
            description: $updatedCategory->description,
            is_active: $updatedCategory->isActive,
            created_at: $updatedCategory->createdAt,
            updated_at: $updatedCategory->updatedAt,
        );
    }
}
