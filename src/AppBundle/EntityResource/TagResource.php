<?php

namespace AppBundle\EntityResource;
use AppBundle\AbstractInterface\AbstractResource;
use AppBundle\Entity\Tag;

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

class TagResource extends AbstractResource
{
    /**
     * @return Tag
     */
    public function create()
    {
        $tag = new Tag();

        $requestContent = $this->decoder();
        $tag->setName($requestContent['name']);

        return $tag;
    }

    public function delete($id)
    {
        $tag = $this->findById('AppBundle:Tag', $id);

        // Remove the association from the picture
        $pictures = $tag->getPictures();
        foreach ($pictures as $picture) {
            $picture->removeTag($tag);
        }

        return $tag;
    }
}