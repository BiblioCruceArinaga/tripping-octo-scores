<?php

    namespace Smartscores\Bundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="scores")
    */
    class Scores {
	
        /**
        * @ORM\Column(type="decimal", length=20)
        * @ORM\Id
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        private $Id_S;

        /**
        * @ORM\Column(type="string", length=100)
        */
        private $Author;

	/**
        * @ORM\Column(type="string", length=200)
        */
        private $Editor;
	
	/**
        * @ORM\Column(type="decimal", length=4)
        */
        private $Year;

	/**
        * @ORM\Column(type="decimal", length=3)
        */
        private $Price;

        /**
         * Get id_s
         *
         * @return string 
         */
        public function getId_S(){
            return $this->Id_S;
        }

        /**
         * Set Id_S
         *
         * @param integer $id_s
         * @return Scores
         */

        public function setId_S($Id_S){
            $this->id_s = $Id_S;

            return $this;
        }

	/**
         * Get author
         *
         * @return string 
         */
        public function getAuthor(){
            return $this->Author;
        }

        /**
         * Set author
         *
         * @param string $author
         * @return Buy
         */

        public function setAuthor($Author){
            $this->author = $Author;

            return $this;
        }

 	/**
         * Get editor
         *
         * @return string 
         */
        public function getEditor(){
            return $this->Editor;
        }

        /**
         * Set Id_S
         *
         * @param string $editor
         * @return Scores
         */

        public function setEditor($Editor){
            $this->editor = $Editor;

            return $this;
        }

	/**
         * Get year
         *
         * @return integer
         */
        public function getYear(){
            return $this->Year;
        }

        /**
         * Set year
         *
         * @param integer $year
         * @return Buy
         */

        public function setYear($Year){
            $this->year = $Year;

            return $this;
        }

	/**
         * Get price
         *
         * @return float
         */
        public function getPrice(){
            return $this->Price;
        }

        /**
         * Set price
         *
         * @param float $price
         * @return Buy
         */

        public function setPrice($Price){
            $this->Price = $Price;

            return $this;
        }


    }
?>
