<?php
    namespace PayPal\Api;

    use PayPal\Common\PayPalModel;

    /**
     * Class WebhookList
     * List of Webhooks.
     * @property \PayPal\Api\Webhook[] webhooks
     */
    class WebhookList extends PayPalModel
    {
        /**
         * Append Webhooks to the list.
         *
         * @param \PayPal\Api\Webhook $webhook
         *
         * @return $this
         */
        public function addWebhook($webhook)
        {
            if ( ! $this->getWebhooks()) {
                return $this->setWebhooks([$webhook]);
            } else {
                return $this->setWebhooks(array_merge($this->getWebhooks(), [$webhook]));
            }
        }

        /**
         * A list of Webhooks.
         * @return \PayPal\Api\Webhook[]
         */
        public function getWebhooks()
        {
            return $this->webhooks;
        }

        /**
         * A list of Webhooks.
         *
         * @param \PayPal\Api\Webhook[] $webhooks
         *
         * @return $this
         */
        public function setWebhooks($webhooks)
        {
            $this->webhooks = $webhooks;

            return $this;
        }

        /**
         * Remove Webhooks from the list.
         *
         * @param \PayPal\Api\Webhook $webhook
         *
         * @return $this
         */
        public function removeWebhook($webhook)
        {
            return $this->setWebhooks(array_diff($this->getWebhooks(), [$webhook]));
        }
    }
