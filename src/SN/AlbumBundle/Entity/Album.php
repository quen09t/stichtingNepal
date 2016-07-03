<?php

namespace SN\AlbumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SN\AlbumBundle\Entity\FileUploader;
use SN\AlbumBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Album
 *
 * @ORM\Table(name="sn_album")
 * @ORM\Entity(repositoryClass="SN\AlbumBundle\Repository\AlbumRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Album
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var File
     *
     * @ORM\OneToMany(targetEntity="SN\AlbumBundle\Entity\Image", mappedBy="album", cascade={"persist"})
     */
    public $images;

    /**
     * @var ArrayCollection
     */
    private $uploadedImages;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Album
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Album
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function removeImage($image){
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    public function getUploadDir()
    {
        return 'uploads/img';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * @ORM\PreFlush()
     */
    public function upload()
    {

        foreach($this->uploadedImages as $uploadedImage)
        {
            $image = new Image();
            $path = $this->getUploadDir();
            
            /*
             * These lines could be moved to the File Class constructor to factorize
             * the File initialization and thus allow other classes to own Files
             */
            $path = sha1(uniqid(mt_rand(), true)).'.'.$uploadedImage->guessExtension();
            $image->setPath($path);
            $image->setSize($uploadedImage->getClientSize());
            $image->setName($uploadedImage->getClientOriginalName());
            $image->setAlbum($this);



            $uploadedImage->move($this->getUploadRootDir(), $path);

            $this->getImages()->add($image);


            unset($uploadedImage);
        }
    }

    /**
     * Add image
     *
     * 
     * @param File $image
     *
     * @return Album
     */
    public function addImage(File $image)
    {
        $this->uploadedImages[] = $image;

        return $this;
    }
}
