<?php

declare(strict_types=1);

namespace Models;

use App\Models\Admin;
use Models\Fixtures\Admins;
use Tests\TestCase;

class AdminModelTest extends TestCase
{
    private Admin $admin;

    public function test_can_instantiate(): void
    {
        $this->admin = Admins::anAdmin();
        $this->admin->save();
    }
    public function test_can_find_all_admins(): void
    {
        $admins = Admin::findAll();

        /** @var Admin $actualAdmin */
        $actualAdmin = $admins->first();

        self::assertEquals($this->admin->getAttributeValue('name'), $actualAdmin->getAttributeValue('name'));
        self::assertEquals($this->admin->getAttributeValue('surname'), $actualAdmin->getAttributeValue('surname'));
        self::assertEquals($this->admin->getAttributeValue('dni'), $actualAdmin->getAttributeValue('dni'));
        self::assertEquals($this->admin->getAttributeValue('email'), $actualAdmin->getAttributeValue('email'));
        self::assertEquals($this->admin->getAttributeValue('password'), $actualAdmin->getAttributeValue('password'));
    }
}
