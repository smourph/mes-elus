<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class City.
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\CityRepository")
 */
class City extends LabelizedData
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
