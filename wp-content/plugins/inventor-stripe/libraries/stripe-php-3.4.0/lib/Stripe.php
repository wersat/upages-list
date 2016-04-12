<?php

namespace Stripe;

class Stripe
{
    // @var string The Stripe API key to be used for requests.
        const VERSION = '3.4.0';

        // @var string The base URL for the Stripe API.
        public static $apiKey;

        // @var string The base URL for the Stripe API uploads endpoint.
        public static $apiBase = 'https://api.stripe.com';

        // @var string|null The version of the Stripe API to use for requests.
        public static $apiUploadBase = 'https://uploads.stripe.com';

        // @var boolean Defaults to true.
        public static $apiVersion = null;
    public static $verifySslCerts = true;

        /**
         * @return string The API key used for requests.
         */
        public static function getApiKey()
        {
            return self::$apiKey;
        }

        /**
         * Sets the API key to be used for requests.
         *
         * @param string $apiKey
         */
        public static function setApiKey($apiKey)
        {
            self::$apiKey = $apiKey;
        }

        /**
         * @return string The API version used for requests. null if we're using the
         *                latest version.
         */
        public static function getApiVersion()
        {
            return self::$apiVersion;
        }

        /**
         * @param string $apiVersion The API version to use for requests.
         */
        public static function setApiVersion($apiVersion)
        {
            self::$apiVersion = $apiVersion;
        }

        /**
         * @return bool
         */
        public static function getVerifySslCerts()
        {
            return self::$verifySslCerts;
        }

        /**
         * @param bool $verify
         */
        public static function setVerifySslCerts($verify)
        {
            self::$verifySslCerts = $verify;
        }
}
