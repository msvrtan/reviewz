<?php

namespace Organization\Repository;

use Organization\Entity\OrganizationEntity;

interface OrganizationRepository
{
    public function findByTitle(string $title);

    public function save(OrganizationEntity $entity);
}
