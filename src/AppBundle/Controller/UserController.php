<?php

namespace AppBundle\Controller;

/**
 * |--------------------------------------------------------------------------
 *
 * @author : Florina Petre, August 2016
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
use AppBundle\EntityResource\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}/{action}", name="getUser", requirements={
     *      "id": "\d+",
     *     "action": "get-one|edit"
     * }, defaults={
     *      "action": "get-one"
     * })
     *
     * @Method("GET")
     * @param $id
     * @param $action
     * @return mixed
     */
    public function getOneAction($id, $action)
    {
        $data = $this->getSerializedResponse([
            'criteria' => 'id',
            'repository' => 'AppBundle:User',
            'parameter' => $id,
            'group' => ["user-{$action}"]
        ]);

        return $data;
    }

    /**
     * @Route("user/{id}/pictures/{start}/{take}", requirements={
     *     "id" = "\d+",
     *     "take" = "\d+",
     *     "start" = "\d+"
     * })
     *
     * @Method("GET")
     * @param $id
     * @param $start
     * @param $take
     * @return mixed
     */
    public function getManyAssociationsAction($id, $start, $take)
    {
        $pictures = $this->getDoctrine()->getManager()
            ->getRepository("AppBundle:User")
            ->getManyPictures($start, $take, $id);

        $data = $this->getSerializedResponse([
            'data' => $pictures
        ]);

        return $data;
    }

    /**
     * @Route("/user", name="createUser")
     * @Method("POST")
     */
    public function createAction()
    {
        return $this->_handleResource(new UserResource($this->container), 'create',
            'The data was successfully added into the database!');
    }

    /**
     * @Route("/user/{id}", name="changeUser", requirements={ "id": "\d+" })
     * @Method("PUT")
     * @param $id
     * @return string|JsonResponse
     */
    public function changeAction($id)
    {
        return $this->_handleResource(new UserResource($this->container), 'change', 'User updated!', $id);

    }

    /**
     * @Route("/user/{id}", name="deleteUser", requirements={ "id": "\d+" })
     * @Method("DELETE")
     * @param $id
     * @return string|JsonResponse
     */
    public function deleteAction($id)
    {
        return $this->_handleResource(new UserResource($this->container), 'delete', 'User deleted!', $id);

    }
}