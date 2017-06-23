<?php

namespace AppBundle\Controller;
use AppBundle\AbstractInterface\AbstractController;
use AppBundle\Entity\Picture;
use AppBundle\EntityResource\PictureResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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

class PictureController extends AbstractController
{
    /**
     * @Route("/picture/{id}/{action}", name="getPicture", requirements={
     *      "id": "\d+",
     *     "action": "get-one|edit"
     * }, defaults={
     *      "action": "get-one"
     * })
     *
     * @Method("GET")
     * @param $id
     * @param $action
     * @return JsonResponse
     */
    public function getOneAction($id, $action)
    {

        $data = $this->getSerializedResponse([
            'criteria' => 'id',
            'repository' => 'AppBundle:Picture',
            'parameter' => $id,
            'group' => ["picture-{$action}"]
        ]);

        return $data;
    }

    /**
     * @Route("/picture/{id}/comments", name="getPictureComments", requirements={ "id": "\d+" })
     *
     * @Method("GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getManyAssociationsAction($id)
    {
        $data = $this->getSerializedResponse([
            'criteria' => 'id',
            'repository' => 'AppBundle:Picture',
            'parameter' => $id,
            'group' => ["picture-get-many-comments"]
        ]);

        return $data;
    }


    /**
     * @Route("/pictures", name="getLatestPictures")
     *
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getManyAction()
    {
        $pictures = $this->getDoctrine()->getManager()
            ->getRepository("AppBundle:Picture")
            ->getManyPictures(0,12,true);

        $data = $this->getSerializedResponse([
            'data' => $pictures
        ]);

        return $data;
    }

    /**
     * @Route("/pictures/{start}/{take}",  requirements={
     *     "start": "\d+",
     *     "take": "\d+"
     * })
     *
     * @Method("GET")
     * @param $start
     * @param $take
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function loadManyAction($start, $take)
    {
        $pictures = $this->getDoctrine()->getManager()
            ->getRepository("AppBundle:Picture")
            ->getManyPictures($start,$take);

        $data = $this->getSerializedResponse([
            'data' => $pictures
        ]);

        return $data;
    }

    /**
     * @Route("/picture/create", name="newPicture")
     * @Method("GET")
     */
    public function newAction()
    {
        return $this->render('@App/Picture/new.html.twig');
    }

    /**
     * @Route("/picture", name="createPicture")
     * @Method("POST")
     * @return JsonResponse|string
     */
    public function createAction()
    {
        return $this->uploadPicture();

    }

    /**
     * @Route("/picture/{id}", name="changePicture", requirements={ "id": "\d+" })
     * @Method("PUT")
     * @param $id
     * @return string|JsonResponse
     */
    public function changeAction($id)
    {
        return $this->_handleResource(new PictureResource($this->container), 'change', 'Picture updated!', $id);

    }

    /**
     * @Route("/picture/{id}", name="deletePicture", requirements={ "id": "\d+" })
     * @Method("DELETE")
     * @param $id
     * @return string|JsonResponse
     */
    public function deleteAction($id)
    {
        return $this->_handleResource(new PictureResource($this->container), 'delete', 'Picture deleted!', $id);

    }
}