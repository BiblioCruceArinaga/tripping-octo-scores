<?php

    namespace Smartscores\Bundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="bonificaciones")
    */
    class Bonificaciones {

        /**
        * @ORM\Column(type="decimal", length=11)
        * @ORM\Id
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        private $id;

        /**
        * @ORM\Column(type="string", length=20)
        */
        private $bonificacion;

        /**
        * @ORM\Column(type="decimal", length=10, scale=2)
        */
        private $cuantia;

        /**
         * Get id
         *
         * @return string 
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set bonificacion
         *
         * @param string $bonificacion
         * @return User
         */
        public function setBonificacion($bonificacion)
        {
            $this->bonificacion = $bonificacion;

            return $this;
        }

        /**
         * Get bonificacion
         *
         * @return string 
         */
        public function getBonificacion()
        {
            return $this->bonificacion;
        }

        /**
         * Set cuantia
         *
         * @param string $cuantia
         * @return User
         */
        public function setCuantia($cuantia)
        {
            $this->cuantia = $cuantia;

            return $this;
        }

        /**
         * Get cuantia
         *
         * @return string 
         */
        public function getCuantia()
        {
            return $this->cuantia;
        }
    }
?>
