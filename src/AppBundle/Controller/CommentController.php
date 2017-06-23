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
use AppBundle\EntityResource\CommentResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class CommentController extends AbstractController
{

    /**
     * @Route("/comment", name="createComment")
     * @Method("POST")
     */
    public function createAction()
    {
        return $this->_handleResource(new CommentResource($this->container), 'create',
            'The data was successfully added into the database!', null, "picture-get-many-comments");
    }

    /**
     * @Route("/comment/{id}", name="changeComment", requirements={ "id": "\d+" })
     * @Method("PUT")
     * @param $id
     * @return string|JsonResponse
     */
    public function changeAction($id)
    {
        return $this->_handleResource(new CommentResource($this->container), 'change', 'Comment updated!', $id);
    }

    /**
     * @Route("/comment/{id}", name="deleteComment", requirements={ "id": "\d+" })
     * @Method("DELETE")
     * @param $id
     * @return string|JsonResponse
     */
    public function deleteAction($id)
    {
        return $this->_handleResource(new CommentResource($this->container), 'delete', 'Comment deleted!', $id);
    }

}