<?php

namespace Kirin\CI\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass
 **/
class User
{
    use TimestrampableTrait;

    /**
     * @ORM\ID
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     **/
    protected $id;

    /** @ORM\Column(type="string", nullable=true)**/
    protected $firstName;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $lastName;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $email;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $emailCanonical;
}
