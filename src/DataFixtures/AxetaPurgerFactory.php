<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Purger\PurgerFactory;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

class AxetaPurgerFactory implements PurgerFactory
{
    /**
     * @see https://stackoverflow.com/questions/64570346/doctrine-fixtures-how-to-override-the-purger-class
     *
     * @param string|null $emName
     * @param EntityManagerInterface $em
     * @param array $excluded
     * @param bool $purgeWithTruncate
     * @return PurgerInterface
     */
    public function createForEntityManager(
        ?string $emName,
        EntityManagerInterface $em,
        array $excluded = [],
        bool $purgeWithTruncate = false
    ): PurgerInterface {
        $purger = new AxetaPurger($em, $excluded);
        $purger->setPurgeMode($purgeWithTruncate ? ORMPurger::PURGE_MODE_TRUNCATE : ORMPurger::PURGE_MODE_DELETE);
        return $purger;
    }
}
