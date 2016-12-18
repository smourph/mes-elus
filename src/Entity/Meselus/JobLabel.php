<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class JobLabel.
 *
 * @ORM\Table(name="job_label")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\JobLabelRepository")
 */
class JobLabel extends LabelizedData
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
