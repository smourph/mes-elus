<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Job.
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\JobRepository")
 */
class Job
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
     * @var JobLabel
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meselus\JobLabel", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="label_id", referencedColumnName="id")
     */
    private $label;

    /**
     * @var JobCategory
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meselus\JobCategory", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var JobFamily
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meselus\JobFamily", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="family_id", referencedColumnName="id")
     */
    private $family;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): JobLabel
    {
        return $this->label;
    }

    public function setLabel(JobLabel $label): Job
    {
        $this->label = $label;

        return $this;
    }

    public function getCategory(): JobCategory
    {
        return $this->category;
    }

    public function setCategory(JobCategory $category): Job
    {
        $this->category = $category;

        return $this;
    }

    public function getFamily(): JobFamily
    {
        return $this->family;
    }

    public function setFamily(JobFamily $family): Job
    {
        $this->family = $family;

        return $this;
    }
}
