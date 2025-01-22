<?php

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\DashboardController;
use App\Controller\Admin\FloorCrudController;
use App\DataFixtures\FloorFixture;
use App\DataFixtures\VenueFixture;
use App\Tests\GetUser;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;
use EasyCorp\Bundle\EasyAdminBundle\Test\Trait\CrudTestFormAsserts;

class FloorCrudControllerTest extends AbstractCrudTestCase
{
    use CrudTestFormAsserts;
    use GetUser;
    use TestAdminIndex;
    use TestAdminNew;
    use TestAdminEdit;

    protected static function getIndexColumnNames(): array
    {
        return ['name', 'venue'];
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    protected function getControllerFqcn(): string
    {
        return FloorCrudController::class;
    }

    public function testIndex(): void
    {
        $this->runIndexPage(FloorFixture::DATA);
    }

    public function testNew(): void
    {
        $newData = [
            'name' => 'Test floor name',
            'venue' => VenueFixture::getIdFromName('CPC'),
        ];

        $this->runNewFormSubmit($newData);
    }

    public function testEdit(): void
    {
        $newData = [
            'name' => 'Test new floor name',
            'venue' => VenueFixture::getIdFromName('CPC'),
        ];

        $this->runEditFormSubmit(FloorFixture::getIdFromName('RDC'), $newData);
    }
}
