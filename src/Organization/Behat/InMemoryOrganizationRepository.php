<?php

namespace Organization\Behat;

use Organization\Entity\OrganizationEntity;
use Organization\Repository\OrganizationRepository;

class InMemoryOrganizationRepository implements OrganizationRepository
{
    private $items;

    public function findByTitle(string $title)
    {
        foreach ($this->items as $item) {
            if ($item->getTitle() === $title) {
                return $item;
            }
        }

        return null;
    }

    public function save(OrganizationEntity $entity)
    {
        $this->items[] = $entity;
    }
}
