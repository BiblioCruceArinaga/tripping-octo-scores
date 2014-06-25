<?php

    namespace Smartscores\Bundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="buy_money")
    */
    class BuyMoney {

        /**
        * @ORM\Column(type="decimal", length=10)
        * @ORM\Id
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        private $Id_M;

        /**
        * @ORM\Column(type="decimal", length=10)
        */
        private $Id_U;

	/**
        * @ORM\Column(type="decimal", length=8)
        */
        private $Date;

        /**
        * @ORM\Column(type="decimal", length=2)
        */
        private $Pay_Method;

        /**
        * @ORM\Column(type="decimal", length=10)
        */
        private $Money;

        /**
         * Set Id_M
         *
         * @param integer $id_m
         * @return Buy_Money
         */

        public function setId_M($Id_M){
            $this->id_m = $Id_M;

            return $this;
        }
	
	/**
         * Get id_m
         *
         * @return string 
         */
        public function getId_M(){
            return $this->Id_M;
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
         * @param integer $Id_U
         * @return Buy_Money
         */

        public function setId_U($Id_U){
            $this->Id_U = $Id_U;

            return $this;
        }
	
	/**
         * Set Date
         *
         * @param integer $Date
         * @return Buy_Money
         */

        public function setDate($Date){
            $this->Date = $Date;

            return $this;
        }
	
	/**
         * Get date
         *
         * @return string 
         */
        public function getDate(){
            return $this->Date;
        }

	/**
         * Get pay_method
         *
         * @return string 
         */
        public function getPay_Method(){
            return $this->Pay_Method;
        }

        /**
         * Set Pay_Method
         *
         * @param integer $Pay_Method
         * @return Buy_Money
         */

        public function setPay_Method($Pay_Method){
            $this->Pay_Method = $Pay_Method;

            return $this;
        }

	/**
         * Get money
         *
         * @return string 
         */
        public function getMoney(){
            return $this->Money;
        }

        /**
         * Set Money
         *
         * @param integer $Money
         * @return Buy_Money
         */

        public function setMoney($Money){
            $this->Money = $Money;

            return $this;
        }
    }
?>
