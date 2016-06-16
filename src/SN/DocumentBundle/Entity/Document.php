<?php

namespace SN\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Document
 *
 * @ORM\Table(name="sn_document")
 * @ORM\Entity(repositoryClass="SN\DocumentBundle\Repository\DocumentRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Document
{
    private $file;

    private $tempFilname;

    public function setFile(UploadedFile $file){
        $this->file = $file;

        if(null !== $this->url){
            $this->tempFilname = $this->url;

            $this->url = null;
            $this->alt = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
        if (null === $this->file){
            return;
        }

        $this->url = $this->file->guessExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */

    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        if (null !== $this->tempFilname){
            $oldFile = $this->getUploadDir().'/'.$this->id.'.'.$this->tempFilname;
            if (file_exists($oldFile))
                unlink($oldFile);
        }

        $this->file->move(
            $this->getUploadDir(),
            $this->id.'.'.$this->url
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload() {
        $this->tempFilname = $this->getUploadDir().'/'.$this->id.'.'.$this->url;
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUpload() {
        if(file_exists($this->tempFilname)){
            unlink($this->tempFilname);
        };
    }

    public function getUploadDir()
    {
        return 'uploads/documents';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    private $webPath;

    public function getWebPath()

    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="documentName", type="string", length=255, nullable=true)
     */
    private $documentName;
    
    


    public function getFile()

    {
        return $this->file;
    }

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
     * Set url
     *
     * @param string $url
     *
     * @return Document
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set documentName
     *
     * @param string $documentName
     *
     * @return Document
     */
    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;

        return $this;
    }

    /**
     * Get documentName
     *
     * @return string
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }
}
