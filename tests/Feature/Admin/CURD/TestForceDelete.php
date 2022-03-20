<?php

declare(strict_types=1);

namespace Tests\Feature\Admin\CURD;

trait TestForceDelete
{
    public function testForceDelete()
    {
        $this->adminGet('forceDelete/' . $this->forceDeleteId)
            ->assertSessionHasAll(static::FORCE_DELETE_SUCCESS_MESSAGE);
    }
}
