<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 16/02/19
 * Time: 06:00
 */

namespace App\Entity\Contracts;

interface Updatable
{
    public function updatableProperties() : array;
}
