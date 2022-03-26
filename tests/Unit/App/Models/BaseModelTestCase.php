<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class BaseModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function fillable(): array;
    abstract protected function casts(): array;

    public function test_it_should_use_expected_traits()
    {
        $usedTraits = array_keys(class_uses($this->model()));

        $this->assertEquals($this->traits(), $usedTraits);
    }

    public function test_it_should_have_correct_fillable_array()
    {
        $fillable = $this->model()->getFillable();

        $this->assertEquals($this->fillable(), $fillable);
    }

    public function test_it_should_have_correct_casts_array()
    {
        $casts = $this->model()->getCasts();

        $this->assertEquals($this->casts(), $casts);
    }
}
