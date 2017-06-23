<?php

namespace AppBundle\EntityResource;

use AppBundle\AbstractInterface\AbstractResource;
use AppBundle\Entity\Picture;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
class PictureResource extends AbstractResource
{
    /**
     * @param $uploadedFile
     * @param $dir
     * @return Picture
     */
    public function create(UploadedFile $uploadedFile, $dir)
    {
        $picture = new Picture();

        $fileExtension = $uploadedFile->guessExtension();

        $fileName = uniqid() . '.' . $fileExtension;

        //move the uploaded file into the dir
        $uploadedFile->move($dir, $fileName);

        //set the data into the entity
        $picture->setFileName($fileName);
        $picture->setExtension($fileExtension);
        $picture->setPath('assets/img/' . $fileName);

        $exif_data = exif_read_data($picture->getPath());
        $picture->setExifData($exif_data);

        $picture->setTitle($this->request->get('title'));
        $picture->setDescription($this->request->get('description'));


        $user = $this->findById('AppBundle:User', $this->request->get('user'));
        $this->_self($picture, $user);

        return $picture;
    }

    public function change($id)
    {
        $picture = $this->findById('AppBundle:Picture', $id);

        $requestContent = $this->decoder();

        $picture->setTitle($requestContent['title']);
        $picture->setDescription($requestContent['description']);
        $picture->setExifData($picture->getExifData());

      //  $user = $picture->getCreatedBy();
      //  $picture->setUser($user);

     //   $this->_self($picture, $user);

        if ($requestContent['tags']) {
            foreach ($requestContent['tags'] as $tagId) {

                $tag = $this->findById('AppBundle:Tag', $tagId);

                if (!$tag->getPictures()->contains($picture)) {
                    $this->setManyToMany('picture', $picture, 'tag', $tag, 'AppBundle:Tag');
                }
            }
        }

        return $picture;
    }

    public function delete($id)
    {
        $picture = $this->findById('AppBundle:Picture', $id);

        $picture->getUser()->removePicture($picture);

        foreach ($picture->getTags() as $tag) {
            $tag->removePicture($picture);
        }

        return $picture;
    }

    /**
     * @param Picture $picture
     * @param $user
     * @return Picture
     */
    private function _self(Picture $picture, $user)
    {
        $this->setManyToOne('picture', $picture, 'user', $user, 'AppBundle:User');

        return $picture;
    }
}