<?php

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Tests;

use Contao\SkeletonBundle\ContaoIsotopeBundle;
use PHPUnit\Framework\TestCase;

class ContaoIsotopeBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoIsotopeBundle();

        $this->assertInstanceOf('Vrpayment\ContaoIsotopeBundle\ContaoIsotopeBundle', $bundle);
    }
}
