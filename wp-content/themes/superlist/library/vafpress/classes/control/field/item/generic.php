<?php

    /**
     * Not really a class, jump simple 'struct' storing multiple choice option item.
     */
    class VP_Control_Field_Item_Generic
    {
        /**
         * @type
         */
        public $img;

        /**
         * @type
         */
        public $value;

        /**
         * @type
         */
        public $label;
        
        /**
         * VP_Control_Field_Item_Generic constructor.
         */
        public function __construct()
        {
        }

        /**
         * @param $img
         *
         * @return $this
         */
        public function img($img)
        {
            $this->img = $img;

            return $this;
        }

        /**
         * @param $value
         *
         * @return $this
         */
        public function value($value)
        {
            $this->value = $value;

            return $this;
        }

        /**
         * @param $label
         *
         * @return $this
         */
        public function label($label)
        {
            $this->label = $label;

            return $this;
        }
    }

    /*
     * EOF
     */
