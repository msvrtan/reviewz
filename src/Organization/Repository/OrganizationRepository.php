<?php

namespace Organization\Repository;

interface OrganizationRepository
{
    public function findByTitle(string $title);
}
