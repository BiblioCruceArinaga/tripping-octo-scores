<?php

    namespace Smartscores\Bundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="buy_scores")
    */
    class BuyScores {
	/**
        * @ORM\Column(type="decimal", length=20)
        * @ORM\Id
        * 
        */
        private $Id_S;

        /**
        * @ORM\Column(type="decimal", length=10)
        * 
        * 
        */
        private $Id_U;

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
         * @return Buy_Scores
         */

        public function setId_S($Id_S){
            $this->Id_S = $Id_S;

            return $this;
        }

	/**
         * Get id_u
         *
         * @return string 
         */
        public function getId_U(){
            return $this->Id_U;
        }

        /**
         * Set Id_U
         *
         * @param integer $id_u
         * @return Buy_Scores
         */

        public function setId_U($Id_U){
            $this->Id_U = $Id_U;

            return $this;
        }
    }
?>
