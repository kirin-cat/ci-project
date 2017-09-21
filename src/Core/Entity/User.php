<?php

namespace Kirin\CI\Core\Entity;

/**
 * @MappedSuperclass
 **/
class User
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $firstName;

    /** @Column(type="string") **/
    protected $lastName;

    /** @Column(type="string") **/
    protected $email;
}
