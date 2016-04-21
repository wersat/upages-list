<?php

    /**
     * Class VP_Option_Control_Field_ImpExp.
     */
    class VP_Option_Control_Field_ImpExp extends VP_Control_Field
    {
        /**
         * @return string
         *
         * @throws \Exception
         */
        public function render()
        {
            $this->_setup_data();

            return VP_View::instance()
                          ->load('option/impexp', $this->get_data());
        }

/**
 * @param array $arr
 * @param null  $class_name
 *
 * @return \VP_Option_Control_Field_ImpExp
 */public static function withArray($arr = [], $class_name = null)
{
    $instance = null === $class_name ? new self() : new $class_name();
    $instance->_basic_make($arr);

    return $instance;
}
    }

    /*
     * EOF
     */
