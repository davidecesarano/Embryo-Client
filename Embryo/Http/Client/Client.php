<?php 

    /**
     * Client
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-client
     */

    namespace Embryo\Http\Client;
    
    use Embryo\Http\Client\Exceptions\{NetworkException, RequestException};
    use Embryo\Http\Message\Response;
    use Psr\Http\Client\ClientInterface;
    use Psr\Http\Message\RequestInterface;
    use Psr\Http\Message\ResponseInterface;
    
    class Client implements ClientInterface 
    {
        /**
         * @var int $timeout
         */
        private $timeout;

        /**
         * @var bool $sslCertificate
         */
        private $sslCertificate;

        /**
         * Set timeout and check for 
         * SSL certificate.
         * 
         * @param int $timeout 
         * @param bool $sslCertificate
         */
        public function __construct(int $timeout = 15, bool $sslCertificate = false)
        {
            $this->timeout = $timeout;
            $this->sslCertificate = $sslCertificate;
        }

        /**
         * @param RequestInterface $request 
         * @return ResponseInterface
         * @throws NetworkException
         * @throws RequestException
         */
        public function sendRequest(RequestInterface $request): ResponseInterface
        {
            $curl = curl_init();

            $headers = [];
            foreach ($request->getHeaders() as $key => $values) {
                $headers[] = $key.': '.$values[0];
            }

            $options = [
                CURLOPT_URL            => (string) $request->getUri(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => $this->timeout,
                CURLOPT_HTTP_VERSION   => $request->getProtocolVersion(),
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_SSL_VERIFYPEER => $this->sslCertificate,
                CURLOPT_SSL_VERIFYHOST => $this->sslCertificate
            ];

            switch ($request->getMethod()) {
                case 'GET':
                    break;
                case 'POST':
                    $options[CURLOPT_POST] = 1;
                    $options[CURLOPT_POSTFIELDS] = (string) $request->getBody();
                    break;
                case 'PATCH':
                case 'PUT':
                case 'DELETE':
                    $options[CURLOPT_CUSTOMREQUEST] = $request->getMethod();
                    $options[CURLOPT_POSTFIELDS] = (string) $request->getBody();
                    break;
                default:
                    throw new RequestException("Unknown HTTP method: '{$request->getMethod()}'", $request);
            }

            $headerLines = [];
            $options[CURLOPT_HEADERFUNCTION] = function ($curl, $headerLine) use (&$headerLines) {
                $len = strlen($headerLine);
                $headerLines[] = $headerLine;
                return $len;
            };

            curl_setopt_array($curl, $options);
            $body = curl_exec($curl);
            if ($body === false) {
                throw new NetworkException(curl_error($curl), $request);
            }
            curl_close($curl);
            
            $headerLines     = $this->discardRedirectsHeaders($headerLines);
            $firstHeader     = $this->composeFirstHeader($headerLines[0]);
            $protocolVersion = $firstHeader[1];
            $statusCode      = $firstHeader[2];
            $reasonPhrase    = $firstHeader[3];
            $responseHeaders = $this->getResponseHeaders($headerLines);
            
            $response = new Response($statusCode, $reasonPhrase, $responseHeaders, $body);
            $response = $response->withProtocolVersion($protocolVersion);
            return $response;
        }

        /**
         * Get headers only for the
         * last request.
         * 
         * @param array $headerLines
         * @return array
         */
        private function discardRedirectsHeaders($headerLines): array
        {
            $lastHttpRequestStartAtIndex = 0;
            for ($i = 0; $i < count($headerLines); ++$i) {
                if (preg_match('/http\/(.+) (\d+) /i', $headerLines[$i], $matches)) {
                    $lastHttpRequestStartAtIndex = $i;
                }
            }
            return array_slice($headerLines, $lastHttpRequestStartAtIndex);
        }

        /**
         * Get status code, protocol version and 
         * reason phrase.
         * 
         * @param string $header 
         * @return array
         */
        private function composeFirstHeader(string $header): array
        {
            preg_match('/http\/(.+) (\d+) (.*)/i', $header, $matches);
            return $matches;
        }

        /**
         * Get response headers.
         * 
         * @param array $headers 
         * @return array
         */
        private function getResponseHeaders(array $headers): array
        {
            array_shift($headers);
            $responseHeaders = [];
            foreach ($headers as $header) {
                $header = explode(':', $header, 2);
                if (count($header) >= 2) {
                    $name = strtoupper(trim($header[0]));
                    $name = str_replace('-', '_', $name);
                    $responseHeaders[$name] = trim($header[1]);
                }
            }
            return $responseHeaders;
        }
    }