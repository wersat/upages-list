<?php
    namespace PayPal\Api;

    use PayPal\Common\PayPalModel;

    /**
     * Class InstallmentInfo
     *  A resource representing installment information available for a transaction.
     * @property string                          installment_id
     * @property string                          network
     * @property string                          issuer
     * @property \PayPal\Api\InstallmentOption[] installment_options
     */
    class InstallmentInfo extends PayPalModel
    {
        /**
         * Installment id.
         *
         * @param string $installment_id
         *
         * @return $this
         */
        public function setInstallmentId($installment_id)
        {
            $this->installment_id = $installment_id;

            return $this;
        }

        /**
         * Credit card network.
         * Valid Values: ["VISA", "MASTERCARD"].
         *
         * @param string $network
         *
         * @return $this
         */
        public function setNetwork($network)
        {
            $this->network = $network;

            return $this;
        }

        /**
         * Credit card issuer.
         *
         * @param string $issuer
         *
         * @return $this
         */
        public function setIssuer($issuer)
        {
            $this->issuer = $issuer;

            return $this;
        }

        /**
         * Installment id.
         * @return string
         */
        public function getInstallmentId()
        {
            return $this->installment_id;
        }

        /**
         * Credit card network.
         * @return string
         */
        public function getNetwork()
        {
            return $this->network;
        }

        /**
         * Credit card issuer.
         * @return string
         */
        public function getIssuer()
        {
            return $this->issuer;
        }

        /**
         * Append InstallmentOptions to the list.
         *
         * @param \PayPal\Api\InstallmentOption $installmentOption
         *
         * @return $this
         */
        public function addInstallmentOption($installmentOption)
        {
            if ( ! $this->getInstallmentOptions()) {
                return $this->setInstallmentOptions([$installmentOption]);
            } else {
                return $this->setInstallmentOptions(array_merge($this->getInstallmentOptions(), [$installmentOption]));
            }
        }

        /**
         * List of available installment options and the cost associated with each one.
         * @return \PayPal\Api\InstallmentOption[]
         */
        public function getInstallmentOptions()
        {
            return $this->installment_options;
        }

        /**
         * List of available installment options and the cost associated with each one.
         *
         * @param \PayPal\Api\InstallmentOption[] $installment_options
         *
         * @return $this
         */
        public function setInstallmentOptions($installment_options)
        {
            $this->installment_options = $installment_options;

            return $this;
        }

        /**
         * Remove InstallmentOptions from the list.
         *
         * @param \PayPal\Api\InstallmentOption $installmentOption
         *
         * @return $this
         */
        public function removeInstallmentOption($installmentOption)
        {
            return $this->setInstallmentOptions(array_diff($this->getInstallmentOptions(), [$installmentOption]));
        }
    }
