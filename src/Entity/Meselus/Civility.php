<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Civility.
 *
 * @ORM\Table(name="civility")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\CivilityRepository")
 */
class Civility extends LabelizedData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function getId(): int
    {
        return $this->id;
    }
}
