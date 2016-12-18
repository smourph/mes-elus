<?php

namespace App\Entity\Meselus;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Actor.
 *
 * @ORM\Table(name="actor")
 * @ORM\Entity(repositoryClass="App\Repository\Meselus\ActorRepository")
 */
class Actor
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
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=15)
     */
    private $uid;

    /**
     * @var Civility
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meselus\Civility", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="civility_id", referencedColumnName="id")
     */
    private $civility;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alpha", type="string", length=255, nullable=true)
     */
    private $alpha;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="day_of_death", type="date", nullable=true)
     */
    private $dayOfDeath;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meselus\City", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="birth_city_id", referencedColumnName="id")
     */
    private $birthCity;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meselus\Country", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="birth_country_id", referencedColumnName="id")
     */
    private $birthCountry;

    /**
     * @var Job
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Meselus\Job", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private $job;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): Actor
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get civility.
     */
    public function getCivility(): Civility
    {
        return $this->civility;
    }

    public function setCivility(Civility $civility): Actor
    {
        $this->civility = $civility;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): Actor
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): Actor
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAlpha(): ?string
    {
        return $this->alpha;
    }

    public function setAlpha(?string $alpha): Actor
    {
        $this->alpha = $alpha;

        return $this;
    }

    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTime $birthday): Actor
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getDayOfDeath(): ?\DateTime
    {
        return $this->dayOfDeath;
    }

    public function setDayOfDeath(?\DateTime $dayOfDeath): Actor
    {
        $this->dayOfDeath = $dayOfDeath;

        return $this;
    }

    public function getBirthCity(): City
    {
        return $this->birthCity;
    }

    public function setBirthCity(City $birthCity): Actor
    {
        $this->birthCity = $birthCity;

        return $this;
    }

    public function getBirthCountry(): Country
    {
        return $this->birthCountry;
    }

    public function setBirthCountry(Country $birthCountry): Actor
    {
        $this->birthCountry = $birthCountry;

        return $this;
    }

    public function getJob(): Job
    {
        return $this->job;
    }

    public function setJob(Job $job): Actor
    {
        $this->job = $job;

        return $this;
    }
}
