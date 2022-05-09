<?php
declare(strict_types=1);

namespace WJCrypto;

use Exception;
use Pecee\Http\Request;
use Pecee\Http\Response;
use Pecee\SimpleRouter\SimpleRouter as Router;
use WJCrypto\DI\Builder;

class Helpers
{
    private const SERVER_CONTAINER = "wjcrypto-nginx";
    private const SECRET_KEY = "S3cr3t";
    private const SECRET_IV = "134679";
    private const METHOD = "AES-256-CBC";

    /**
     * Get url for a route by using either name/alias, class or method name.
     *
     * The name parameter supports the following values:
     * - Route name
     * - Controller/resource name (with or without method)
     * - Controller class name
     *
     * When searching for controller/resource by name, you can use this syntax "route.name@method".
     * You can also use the same syntax when searching for a specific controller-class "MyController@home".
     * If no arguments is specified, it will return the url for the current loaded route.
     *
     * @param string|null $name
     * @param string|array|null $parameters
     * @param array|null $getParams
     * @return \Pecee\Http\Url
     * @throws \InvalidArgumentException
     */
    public static function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
    {
        return Router::getUrl($name, $parameters, $getParams);
    }

    /**
     * @return Response
     */
    public static function response(): Response
    {
        return Router::response();
    }

    /**
     * @return Request
     */
    public static function request(): Request
    {
        return Router::request();
    }

    /**
     * Get input class
     * @param string|null $index Parameter index name
     * @param string|null $defaultValue Default return value
     * @param array ...$methods Default methods
     * @return \Pecee\Http\Input\InputHandler|array|string|null
     */
    public static function input($index = null, $defaultValue = null, ...$methods)
    {
        if ($index !== null) {
            return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
        }

        return request()->getInputHandler();
    }

    /**
     * @param string $url
     * @param int|null $code
     */
    public static function redirect(string $url, ?int $code = null): void
    {
        if ($code !== null) {
            response()->httpCode($code);
        }

        response()->redirect($url);
    }

    /**
     * Get current csrf-token
     * @return string|null
     */
    public static function csrf_token(): ?string
    {
        $baseVerifier = Router::router()->getCsrfVerifier();
        if ($baseVerifier !== null) {
            return $baseVerifier->getTokenProvider()->getToken();
        }

        return null;
    }

    public static function encryptData($string)
    {
        $output = false;
        $key = hash('sha256', self::SECRET_KEY);
        $iv = substr(hash('sha256', self::SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, self::METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public static function decryptData($string)
    {
        $key = hash('sha256', self::SECRET_KEY);
        $iv = substr(hash('sha256', self::SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), self::METHOD, $key, 0, $iv);
        return $output;
    }

    public static function hasSession()
    {
        if(isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }


    public static function getContainer($instance)
    {
        return Builder::buildContainer()->get($instance);
    }

    public static function getApiConnection(string $endpoint, array $data, bool $returnTransfer = true)
    {
        $url =  'http://' . self::SERVER_CONTAINER . "/rest/API" . $endpoint;

        try {
            $curl_handler = curl_init($url);

            // Check if initialization had gone wrong*
            if ($curl_handler === false) {
                throw new Exception('Failed to initialize');
            }

            $request_body = json_encode($data);

            if(self::hasSession()) {
                curl_setopt(
                    $curl_handler,
                    CURLOPT_HTTPHEADER,
                    [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $_SESSION['token']
                    ]
                );
            } else {
                curl_setopt($curl_handler, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            }

            curl_setopt($curl_handler, CURLOPT_POST, true);
            curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $request_body);
            curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($curl_handler);

            // Check the return value of curl_exec()
            if ($result === false) {
                throw new Exception(curl_error($curl_handler), curl_errno($curl_handler));
            }

            curl_close($curl_handler);

            if($returnTransfer) {
                $json = json_decode($result);
                return $json;
            }
        } catch (Exception $e) {
            trigger_error(sprintf(
                "Curl failed with error #%d: %s",
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }
    }

    /**
     * apiResponse
     *
     * Returns the base response array. Can also receive 2 optional parameters to set additional data
     *
     * @param   string  $message
     * @param   array   $optParams
     * @return  array
     */
    public static function apiResponse(string $message, array $optParams = [])
    {
        if(count($optParams)) {
            $data = [
                'statusCode' => http_response_code(),
                'message' => $message
            ];

            foreach ($optParams as $key => $value) {
                $data[$key] = $value;
            }
        } else {
            $data = [
                'statusCode' => http_response_code(),
                'message' => $message
            ];
        }

        self::response()->json($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
