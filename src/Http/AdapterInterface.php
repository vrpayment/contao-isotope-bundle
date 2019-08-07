<?php


namespace Vrpayment\ContaoIsotopeBundle\Http;


interface AdapterInterface
{
    /**
     * Returns the response data.
     *
     * @param string $method
     * @param string $path
     * @param array  $data
     *
     * @return mixed
     */
    public function action(string $method, string $path, array $data = []);

    /**
     * Returns the access token.
     *
     * @return string|null
     */
    public function getAccessToken();

    /**
     * Returns the adapter config.
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function getConfig($key = null);
}
