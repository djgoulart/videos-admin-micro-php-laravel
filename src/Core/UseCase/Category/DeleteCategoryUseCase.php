<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\{
    DeleteCategoryInputDto,
    DeleteCategoryOutputDto,
};

class DeleteCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DeleteCategoryInputDto $categoryInput): DeleteCategoryOutputDto
    {
        $isDeleted = $this->repository->delete($categoryInput->id);

        return new DeleteCategoryOutputDto(
            success: $isDeleted
        );
    }
}
