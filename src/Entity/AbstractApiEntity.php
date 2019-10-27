<?php

namespace App\Entity;

interface AbstractApiEntity
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function update(AbstractApiEntity $new);
}
