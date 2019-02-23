<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class JobFamily.
 *
 * @ORM\Table(name="job_family")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\JobFamilyRepository")
 */
class JobFamily extends LabelizedData
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
