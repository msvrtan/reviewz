<?php

declare(strict_types=1);

namespace Geo\Repository;

use Geo\Entity\CityEntity;
use Geo\Entity\CityId;

interface CityRepository
{
    public function save(CityEntity $entity);

    public function load(CityId $id): CityEntity;
}
