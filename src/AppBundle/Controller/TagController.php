<?php

namespace AppBundle\Controller;

use AppBundle\AbstractInterface\AbstractController;
use AppBundle\EntityResource\TagResource;
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
class TagController extends AbstractController
{
    /**
     * @Route("/tag/{id}", name="getTag", requirements={ "id": "\d+" })
     *
     * @Method("GET")
     * @param $id
     * @return mixed
     */
    public function getOneAction($id)
    {
        $data = $this->getSerializedResponse([
            'criteria' => 'id',
            'repository' => 'AppBundle:Tag',
            'parameter' => $id,
            'group' => ["tag-get-one"]
        ]);

        return $data;
    }

    /**
     * @Route("/tag/s/{query}", name="getTagsForSuggest", defaults={ "query": "" })
     *
     * @Method("GET")
     * @param $query
     * @return mixed
     */
    public function getManyForSuggestAction($query)
    {
        if ($query) {
            $tags = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Tag')
                ->getManyForSuggest($query);

            $data = $this->getSerializedResponse([
                'data' => $tags
            ]);

        } else {
            $data = $this->getSerializedResponse([
                'repository' => 'AppBundle:Tag',
                'function' => 'findAll',
                'group' => ["tag-get-many-for-suggest"]
            ]);
        }

        return $data;
    }

    /**
     * @Route("/tag", name="createTag")
     * @Method("POST")
     */
    public function createAction()
    {
        return $this->_handleResource(new TagResource($this->container), 'create',
            'The tag was created!');
    }
    /**
     * @Route("/tag/{id}", name="deleteTag", requirements={ "id": "\d+" })
     * @Method("DELETE")
     * @param $id
     * @return string|JsonResponse
     */
    public function deleteAction($id)
    {
        return $this->_handleResource(new TagResource($this->container), 'delete', 'Tag deleted!', $id);
    }
}