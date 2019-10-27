<?php

namespace App\Entity\Datagouv\Acteur;

use App\Entity\AbstractApiEntity;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class InfoNaissance.
 *
 * @ORM\Table(name="acteur_etatcivil_infonaissance")
 * @ORM\Entity(repositoryClass="App\Repository\Datagouv\Acteur\InfoNaissanceRepository")
 */
class InfoNaissance implements AbstractApiEntity
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
     * @var DateTimeInterface|null
     *
     * @ORM\Column(name="dateNais", type="date", nullable=true)
     */
    private $dateNais;

    /**
     * @var string|null
     *
     * @ORM\Column(name="villeNais", type="string", length=255, nullable=true)
     */
    private $villeNais;

    /**
     * @var string|null
     *
     * @ORM\Column(name="depNais", type="string", length=255, nullable=true)
     */
    private $depNais;

    /**
     * @var string|null
     *
     * @ORM\Column(name="paysNais", type="string", length=255, nullable=true)
     */
    private $paysNais;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDateNais(): ?DateTimeInterface
    {
        return $this->dateNais;
    }

    public function setDateNais(?DateTimeInterface $dateNais): InfoNaissance
    {
        $this->dateNais = $dateNais;

        return $this;
    }

    public function getVilleNais(): ?string
    {
        return $this->villeNais;
    }

    public function setVilleNais(?string $villeNais): InfoNaissance
    {
        $this->villeNais = $villeNais;

        return $this;
    }

    public function getDepNais(): ?string
    {
        return $this->depNais;
    }

    public function setDepNais(?string $depNais): InfoNaissance
    {
        $this->depNais = $depNais;

        return $this;
    }

    public function getPaysNais(): ?string
    {
        return $this->paysNais;
    }

    public function setPaysNais(?string $paysNais): InfoNaissance
    {
        $this->paysNais = $paysNais;

        return $this;
    }

    public function update(AbstractApiEntity $new): InfoNaissance
    {
        $this->setPaysNais($new->getPaysNais())
            ->setDepNais($new->getDepNais())
            ->setVilleNais($new->getVilleNais())
            ->setDateNais($new->getDateNais());

        return $this;
    }
}
