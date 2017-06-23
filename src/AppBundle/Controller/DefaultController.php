<?php

namespace AppBundle\Controller;

/**
 * |--------------------------------------------------------------------------
 *
 * @author : Avram Cosmin, info@sprindo.co.uk, August 2016
 *
 * |--------------------------------------------------------------------------
 *
 *
 *
 *
 *
 */

use AppBundle\AbstractInterface\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function defaultAction()
    {
        return $this->render('base.html.twig');
    }

    public function removeTrailingSlashAction(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //return $error and $lastUsername
        return $this->render(
            'login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    /**
     * @Route("/current-user")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getCurrentUserAction()
    {
        if ($user = $this->getUser()) {

            return new JsonResponse(['data' => [
                'id' => $user->getId(),
                'firstLastName' => $user->getFirstLastName()
            ]]);
        }

        return new JsonResponse(['data' => null]);
    }
}