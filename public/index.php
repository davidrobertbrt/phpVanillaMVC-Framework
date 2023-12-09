<?php

/**
 * This file serves as a security measure to safeguard the source code from public access on the website.
 * It ensures that the initialization script is required before any further processing
 */

require_once '../app/init.php';

/**
 * PHPVanillaMVC-Framework
 * 
 * Author: David - Robert Bratosin
 * @version 0.2.0
 * 
 * Changes from the last version:
 *
 * - Added autoloading for controllers and middlewares
 * - Improved error handling in the Routing, Request classes
 * - New URL structure for the descriptors
 * - New mapping for better readibility
 * - Now the router supports callable functions as handlers
 * 
 * Deprecated functionality:
 * - The cookie class is no longer present as it will be rewritten in a new module for session managing.
 * 
 */