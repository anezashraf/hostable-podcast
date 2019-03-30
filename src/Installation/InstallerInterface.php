<?php

namespace App\Installation;

interface InstallerInterface
{
    public function install() : string;
}
