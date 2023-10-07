<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

class AxetaPurger extends ORMPurger
{
    /**
     * {@inheritDoc}
     */
    public function __construct(private readonly EntityManagerInterface $entityManager, array $excluded = [])
    {
        parent::__construct($this->entityManager, $excluded);
    }

    /**
     * @throws Exception
     */
    public function purge(): void
    {
        $connection = $this->entityManager->getConnection();
        try {
            $connection->executeStatement('SET FOREIGN_KEY_CHECKS = 0');
            parent::purge();
        } finally {
            $connection->executeStatement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}