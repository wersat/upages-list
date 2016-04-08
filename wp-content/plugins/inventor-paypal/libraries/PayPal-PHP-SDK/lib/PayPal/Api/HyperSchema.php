<?php
    namespace PayPal\Api;

    use PayPal\Common\PayPalModel;

    /**
     * Class HyperSchema
     * @package PayPal\Api
     * @property \PayPal\Api\Links[] links
     * @property string              fragmentResolution
     * @property bool                readonly
     * @property string              contentEncoding
     * @property string              pathStart
     * @property string              mediaType
     */
    class HyperSchema extends PayPalModel
    {
        /**
         * Sets FragmentResolution
         *
         * @param string $fragmentResolution
         *
         * @return $this
         */
        public function setFragmentResolution($fragmentResolution)
        {
            $this->fragmentResolution = $fragmentResolution;

            return $this;
        }

        /**
         * Sets Readonly
         *
         * @param bool $readonly
         *
         * @return $this
         */
        public function setReadonly($readonly)
        {
            $this->readonly = $readonly;

            return $this;
        }

        /**
         * Sets ContentEncoding
         *
         * @param string $contentEncoding
         *
         * @return $this
         */
        public function setContentEncoding($contentEncoding)
        {
            $this->contentEncoding = $contentEncoding;

            return $this;
        }

        /**
         * Sets PathStart
         *
         * @param string $pathStart
         *
         * @return $this
         */
        public function setPathStart($pathStart)
        {
            $this->pathStart = $pathStart;

            return $this;
        }

        /**
         * Sets MediaType
         *
         * @param string $mediaType
         *
         * @return $this
         */
        public function setMediaType($mediaType)
        {
            $this->mediaType = $mediaType;

            return $this;
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
         * Gets Links
         * @return \PayPal\Api\Links[]
         */
        public function getLinks()
        {
            return $this->links;
        }

        /**
         * Sets Links
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
         * Gets FragmentResolution
         * @return string
         */
        public function getFragmentResolution()
        {
            return $this->fragmentResolution;
        }

        /**
         * Gets Readonly
         * @return bool
         */
        public function getReadonly()
        {
            return $this->readonly;
        }

        /**
         * Gets ContentEncoding
         * @return string
         */
        public function getContentEncoding()
        {
            return $this->contentEncoding;
        }

        /**
         * Gets PathStart
         * @return string
         */
        public function getPathStart()
        {
            return $this->pathStart;
        }

        /**
         * Gets MediaType
         * @return string
         */
        public function getMediaType()
        {
            return $this->mediaType;
        }

    }
