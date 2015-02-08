<?php

// src/Blogger/BlogBundle/Entity/Blog.php

namespace BRO\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="BRO\BlogBundle\Entity\BlogRepository")
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks
 */
class Blog {

    /**
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $author;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $blog;

    /**
     * Attached File Name 
     * 
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $image = null;

    /**
     * @ORM\Column(type="text")
     */
    protected $tags;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    protected $comments;

    /**
     * @Assert\Image()
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    public function __construct() {
        $this->comments = new ArrayCollection();

        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        //$user = $serviceContainer->get('security.context')->getToken()->getUser();
        //$this->setAuthor($user);
    }

    public function addComment(Comment $comment) {
        $this->comments[] = $comment;
    }

    public function getComments() {
        return $this->comments;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Blog
     */
    public function setTitle($title) {
        $this->title = $title;
        $this->setSlug($this->title);
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Blog
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set blog
     *
     * @param string $blog
     * @return Blog
     */
    public function setBlog($blog) {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return string 
     */
    public function getBlog($length = null) {
        if (false === is_null($length) && $length > 0)
            return substr($this->blog, 0, $length);
        else
            return $this->blog;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Blog
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Blog
     */
    public function setTags($tags) {
        if (is_array($tags)) {
            $this->tags = implode(', ', $tags);
        }
        //$this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Blog
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Blog
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Remove comments
     *
     * @param \BRO\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\BRO\BlogBundle\Entity\Comment $comments) {
        $this->comments->removeElement($comments);
    }

    public function __toString() {
        return $this->getTitle();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Blog
     */
    public function setSlug($slug) {
        $this->slug = $this->slugify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate

        if (function_exists('iconv')) {
            $text = iconv('utf-8', "us-ascii//IGNORE//TRANSLIT", $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    protected function getUploadDir() {
        return 'uploads/blogs';
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    public function getWebPath() {
        return null === $this->image ? null : $this->getUploadDir() . '/' . $this->image;
    }

    public function getAbsolutePath() {
        return null === $this->image ? null : $this->getUploadRootDir() . '/' . $this->image;
    }

    /**
     * @ORM\prePersist
     * @ORM\preUpdate
     */
    public function hook_setImage() {
        //self::Bro_log("Try to update (pre) 'file' in Blog entity...");
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $this->image = uniqid() . 
                    //'_' . $this->getFile()->getClientOriginalName(). 
                    '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\postPersist
     * @ORM\postUpdate
     */
    public function hook_setFile() {
        //self::Bro_log("Try to update (post) 'file' in Blog entity...");
        if (null === $this->getFile()) {
            self::Bro_log("Nothing to update - 'file' is empty!");
            return;
        }
        self::Bro_log("$this->image created!");
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->image);

        //unset($this->file);
        $this->setFile(null);
    }

    /**
     * @ORM\postRemove
     */
    public function hook_unsetFile() {
        $file = $this->getAbsolutePath();

        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function hook_setUpdated() {
        //self::Bro_log("Updating 'Updated' in Blog entity...");
        $this->setUpdated(new \DateTime());
    }

    private static function Bro_log($message) {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $logger = $kernel->getContainer()->get('logger');
        $logger->info($message);
    }

}
