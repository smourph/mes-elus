<?php

namespace App\Entity\Datagouv\Acteur;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Ident.
 *
 * @ORM\Table(name="acteur_etatcivil_ident")
 * @ORM\Entity(repositoryClass="App\Repository\Datagouv\Acteur\IdentRepository")
 */
class Ident
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
     * @var string|null
     *
     * @ORM\Column(name="civ", type="string", length=10, nullable=true)
     */
    private $civ;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alpha", type="string", length=255, nullable=true)
     */
    private $alpha;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCiv(): ?string
    {
        return $this->civ;
    }

    public function setCiv(?string $civ): Ident
    {
        $this->civ = $civ;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): Ident
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): Ident
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAlpha(): ?string
    {
        return $this->alpha;
    }

    public function setAlpha(?string $alpha): Ident
    {
        $this->alpha = $alpha;

        return $this;
    }

    public function update(Ident $new): Ident
    {
        $this->setAlpha($new->getAlpha())
            ->setNom($new->getNom())
            ->setPrenom($new->getPrenom())
            ->setCiv($new->getCiv());

        return $this;
    }
}
