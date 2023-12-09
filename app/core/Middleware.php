<?php
/**
 * Middleware Interface
 * 
 * This file defines the 'Middleware' interface, which serves as a blueprint for
 * creating middleware classes. Middleware classes implement the '__invoke' method,
 * allowing them to be invoked as callables.
 * 
 * Middleware classes designed to work within a web application should adhere to
 * the following guidelines:
 * 
 * 1. **Interface Implementation:**
 *    - Implement the 'Middleware' interface.
 * 
 * 2. **Method Signature:**
 *    - The '__invoke' method should accept the request as a parameter and return
 *      the modified request or a 'Response' object.
 * 
 * Usage Notes:
 * - Create middleware classes by implementing this 'Middleware' interface.
 * - Middlewares should be stored in the 'app/middlewares' directory.
 * - Middleware classes must accept the request as a parameter and return either
 *   the modified request or a 'Response' object if the request is invalid.
 * 
 * Example:
 * ```php
 * class ExampleMiddleware implements Middleware {
 *     public function __invoke($req) {
 *         // Perform middleware logic
 *         // Modify the $req as needed
 *         // Return the modified $req or a 'Response' object
 *     }
 * }
 * ```
 * 
 * @see Response
 */

interface Middleware{
    public function __invoke($req);
}