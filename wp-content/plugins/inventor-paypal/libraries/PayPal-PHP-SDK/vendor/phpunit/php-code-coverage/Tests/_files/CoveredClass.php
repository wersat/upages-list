<?php

    class CoveredParentClass
    {
        public function publicMethod()
        {
            $this->protectedMethod();
        }

        protected function protectedMethod()
        {
            $this->privateMethod();
        }

        private function privateMethod()
        {
        }
    }

    class CoveredClass extends CoveredParentClass
    {
        private function privateMethod()
        {
        }

        protected function protectedMethod()
        {
            parent::protectedMethod();
            $this->privateMethod();
        }

        public function publicMethod()
        {
            parent::publicMethod();
            $this->protectedMethod();
        }
    }
