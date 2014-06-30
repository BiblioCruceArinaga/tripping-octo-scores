<?php

    namespace Smartscores\Bundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="english")
    */
    class English {

        /**
        * @ORM\Column(type="decimal", length=20)
        * @ORM\Id
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        private $Id_S;

        /**
        * @ORM\Column(type="string", length=200)
        */
        private $Name_Song;

	/**
        * @ORM\Column(type="string", length=10)
        */
        private $instrument;
	
	/**
        * @ORM\Column(type="string", length=2000)
        */
        private $Description;

	/**
        * @ORM\Column(type="string", length=100)
        */
        private $URL;
	
	/**
	* @ORM\Column(type="string", length=500)
	*/
	private $URL_Image;

        /**     
         * Get Id
         *
         * @return string 
         */
        public function getId_S(){
            return $this->Id_S;
        }

	/**
         * Get name_song
         *
         * @return string 
         */
        public function getNameSong(){
            return $this->Name_Song;
        }

        /**
         * Set author
         *
         * @param string $name_song
         * @return English
         */

        public function setNameSong($Name_Song){
            $this->name_song = $Name_Song;

            return $this;
        }

 	/**
         * Get instrument
         *
         * @return string 
         */
        public function getInstrument(){
            return $this->Instrument;
        }

        /**
         * Set instrument
         *
         * @param string $instrument
         * @return English
         */

        public function setInstrument($Instrument){
            $this->instrument = $Instrument;

            return $this;
        }

	/**
         * Get description
         *
         * @return string
         */
        public function getDescription(){
            return $this->Description;
        }

        /**
         * Set description
         *
         * @param string $description
         * @return English
         */

        public function setDescription($Description){
            $this->description = $Description;

            return $this;
        }

	/**
         * Get url
         *
         * @return string
         */
        public function getURL(){
            return $this->URL;
        }

        /**
         * Set url
         *
         * @param string $url
         * @return English
         */

        public function setURL($URL){
            $this->URL = $URL;

            return $this;
        }

	/**
         * Get url_image
         *
         * @return string
         */
        public function getURL_Image(){
            return $this->URL_Image;
        }

        /**
         * Set url_image
         *
         * @param string $url_image
         * @return English
         */

        public function setURL_Image($URL){
            $this->URL_Image = $URL;

            return $this;
        }

    }
?>
