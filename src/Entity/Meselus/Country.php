<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Country.
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\CountryRepository")
 */
class Country extends LabelizedData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
