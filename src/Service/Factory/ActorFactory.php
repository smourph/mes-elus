<?php

namespace App\Service\Factory;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\Ident;
use App\Entity\Datagouv\Acteur\InfoNaissance;
use App\Entity\Datagouv\Acteur\Profession;
use App\Entity\Meselus\Actor;
use App\Entity\Meselus\City;
use App\Entity\Meselus\Civility;
use App\Entity\Meselus\Country;
use App\Entity\Meselus\Job;
use App\Entity\Meselus\JobCategory;
use App\Entity\Meselus\JobFamily;
use App\Entity\Meselus\JobLabel;

/**
 * Class ActorFactory.
 */
class ActorFactory
{
    public static function buildFromActeur(Acteur $acteur): Actor
    {
        $etatCivil = $acteur->getEtatCivil();
        $ident = $etatCivil->getIdent() ?: new Ident();
        $infoNaissance = $etatCivil->getInfoNaissance() ?: new InfoNaissance();
        $profession = $acteur->getProfession() ?: new Profession();

        $actor = (new Actor())
            ->setUid($acteur->getUid())
            ->setLastname($ident->getNom())
            ->setFirstname($ident->getPrenom())
            ->setAlpha($ident->getAlpha())
            ->setBirthday($infoNaissance->getDateNais())
            ->setDayOfDeath($etatCivil->getDateDeces());

        return $actor;

        $villeNais = $infoNaissance->getVilleNais();
        $birthCity = $this->em->getRepository(City::class)
            ->findOneBy(['label' => $villeNais]);
        if (!$birthCity) {
            $birthCity = (new City())->setLabel($villeNais);
            $this->em->persist($birthCity);
            $this->em->flush();
        }
        $actor->setBirthCity($birthCity);

        $paysNais = $infoNaissance->getPaysNais();
        $birthCountry = $this->em->getRepository(Country::class)
            ->findOneBy(['label' => $paysNais]);
        if (!$birthCountry) {
            $birthCountry = (new Country())->setLabel($paysNais);
            $this->em->persist($birthCountry);
            $this->em->flush();
        }
        $actor->setBirthCountry($birthCountry);

        $job = $this->em->getRepository(Job::class)
            ->findOneBy(['label' => $profession->getLibelleCourant()]);
        if (!$job) {
            $job = new Job();

            $libelleCourant = $profession->getLibelleCourant();
            $jobLabel = $this->em->getRepository(JobLabel::class)
                ->findOneBy(['label' => $libelleCourant]);
            if (!$jobLabel) {
                $jobLabel = (new JobLabel())->setLabel($libelleCourant);
                $this->em->persist($jobLabel);
                $this->em->flush();
            }
            $job->setLabel($jobLabel);

            $catSocPro = $profession->getSocProcINSEE()->getCatSocPro();
            $jobCategory = $this->em->getRepository(JobCategory::class)
                ->findOneBy(['label' => $catSocPro]);
            if (!$jobCategory) {
                $jobCategory = (new JobCategory())->setLabel($catSocPro);
                $this->em->persist($jobCategory);
                $this->em->flush();
            }
            $job->setCategory($jobCategory);

            $famSocPro = $profession->getSocProcINSEE()->getFamSocPro();
            $jobFamily = $this->em->getRepository(JobFamily::class)
                ->findOneBy(['label' => $famSocPro]);
            if (!$jobFamily) {
                $jobFamily = (new JobFamily())->setLabel($famSocPro);
                $this->em->persist($jobFamily);
                $this->em->flush();
            }
            $job->setFamily($jobFamily);

            $this->em->persist($job);
            $this->em->flush();
        }
        $actor->setJob($job);

        return $actor;
    }

    private function createCivility()
    {
        return (new Civility())
            ->setLabel($civ);

        $civ = $ident->getCiv();
        $civility = $this->em->getRepository(Civility::class)
            ->findOneBy(['label' => $civ]);
        if (!$civility) {
            $civility = (new Civility())->setLabel($civ);
            $this->em->persist($civility);
            $this->em->flush();
        }
        $actor->setCivility($civility);
    }
}
