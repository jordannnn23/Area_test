<?php

/*
 * This file is part of Psy Shell.
 *
<<<<<<< HEAD
 * (c) 2012-2022 Justin Hileman
=======
 * (c) 2012-2023 Justin Hileman
>>>>>>> develop
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\VersionUpdater;

use Psy\Shell;

/**
 * A version checker stub which always thinks the current version is up to date.
 */
class NoopChecker implements Checker
{
<<<<<<< HEAD
    /**
     * @return bool
     */
=======
>>>>>>> develop
    public function isLatest(): bool
    {
        return true;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
=======
>>>>>>> develop
    public function getLatest(): string
    {
        return Shell::VERSION;
    }
}
