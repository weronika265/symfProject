<?php
/**
 * Hello World controller.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class HelloWorldController.
 */
class HelloWorldController
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     */
    public function index(): Response
    {
        return new Response('Hello World!');
    }
}
