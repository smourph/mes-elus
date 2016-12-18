<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class JobCategory.
 *
 * @ORM\Table(name="job_category")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\JobCategoryRepository")
 */
class JobCategory extends LabelizedData
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
