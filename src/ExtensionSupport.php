<?php

/*
 * This file is part of the fXmlRpc Serialization package.
 *
 * (c) Lars Strojny <lstrojny@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace fXmlRpc\Serialization;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
interface ExtensionSupport
{
    const EXTENSION_NIL = 'nil';

    /**
     * Enables an extension
     *
     * @param string $extension
     */
    public function enableExtension($extension);

    /**
     * Disables an extension
     *
     * @param string $extension
     */
    public function disableExtension($extension);

    /**
     * Returns true if an extension is enabled
     *
     * @param string $extension
     *
     * @return boolean
     */
    public function isExtensionEnabled($extension);
}
