<?php

namespace AppBundle\EntityResource;

use AppBundle\AbstractInterface\AbstractResource;
use AppBundle\Entity\Comment;

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
class CommentResource extends AbstractResource
{
    /**
     * @return Comment
     */
    public function create()
    {
        $comment = new Comment();

        $this->_self($comment);

        return $comment;

    }

    public function change($id)
    {
        $comment = $this->findById('AppBundle:Comment', $id);

        $this->_self($comment);

        return $comment;
    }

    public function delete($id)
    {
        $comment = $this->findById('AppBundle:Comment', $id);

        // Remove the association from the picture
        $comment->getPicture()->removeComment($comment);

        return $comment;
    }

    /**
     * @param $entity
     * @return  Comment
     */
    private function _self(Comment $entity)
    {
        $requestContent = $this->decoder();
        $entity->setContent($requestContent['content']);

        $picture = $this->findById('AppBundle:Picture', $requestContent['picture']);
        $this->setManyToOne('comment', $entity, 'picture', $picture, 'AppBundle:Picture');

        return $entity;
    }
}