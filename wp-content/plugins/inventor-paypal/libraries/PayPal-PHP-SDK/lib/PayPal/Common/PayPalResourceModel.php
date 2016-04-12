<?php
    namespace PayPal\Common;

    use PayPal\Rest\ApiContext;
    use PayPal\Rest\IResource;
    use PayPal\Transport\PayPalRestCall;

    /**
     * Class PayPalResourceModel
     * An Executable PayPalModel Class.
     * @property \PayPal\Api\Links[] links
     */
    class PayPalResourceModel extends PayPalModel implements IResource
    {
        /**
         * Sets Links.
         *
         * @param \PayPal\Api\Links[] $links
         *
         * @return $this
         */
        public function setLinks($links)
        {
            $this->links = $links;

            return $this;
        }

        /**
         * Gets Links.
         * @return \PayPal\Api\Links[]
         */
        public function getLinks()
        {
            return $this->links;
        }

        public function getLink($rel)
        {
            foreach ($this->links as $link) {
                if ($link->getRel() == $rel) {
                    return $link->getHref();
                }
            }

            return;
        }

        /**
         * Append Links to the list.
         *
         * @param \PayPal\Api\Links $links
         *
         * @return $this
         */
        public function addLink($links)
        {
            if ( ! $this->getLinks()) {
                return $this->setLinks([$links]);
            } else {
                return $this->setLinks(array_merge($this->getLinks(), [$links]));
            }
        }

        /**
         * Remove Links from the list.
         *
         * @param \PayPal\Api\Links $links
         *
         * @return $this
         */
        public function removeLink($links)
        {
            return $this->setLinks(array_diff($this->getLinks(), [$links]));
        }

        /**
         * Execute SDK Call to Paypal services.
         *
         * @param string         $url
         * @param string         $method
         * @param string         $payLoad
         * @param array          $headers
         * @param ApiContext     $apiContext
         * @param PayPalRestCall $restCall
         * @param array          $handlers
         *
         * @return string json response of the object
         */
        protected static function executeCall(
            $url,
            $method,
            $payLoad,
            $headers = [],
            $apiContext = null,
            $restCall = null,
            $handlers = ['PayPal\Handler\RestHandler']
        ) {
            //Initialize the context and rest call object if not provided explicitly
            $apiContext = $apiContext ? $apiContext : new ApiContext(self::$credential);
            $restCall   = $restCall ? $restCall : new PayPalRestCall($apiContext);
            //Make the execution call
            $json = $restCall->execute($handlers, $url, $method, $payLoad, $headers);

            return $json;
        }
    }
