<?php

namespace Fxmlrpc\Serialization;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
interface ExtensionSupport
{
    const EXTENSION_NIL = 'nil';

    /**
     * Enables an extension.
     *
     * @param string $extension
     */
    public function enableExtension($extension);

    /**
     * Disables an extension.
     *
     * @param string $extension
     */
    public function disableExtension($extension);

    /**
     * Returns true if an extension is enabled.
     *
     * @param string $extension
     *
     * @return bool
     */
    public function isExtensionEnabled($extension);
}
