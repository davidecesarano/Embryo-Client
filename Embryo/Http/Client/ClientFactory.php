<?php 

    /**
     * ClientFactory
     *
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-client
     */
    namespace Embryo\Http\Client;

    use Embryo\Http\Message\Request;
    use Psr\Http\Message\{RequestInterface, ResponseInterface};

    class ClientFactory 
    {
        /**
         * @var array $headers 
         */
        private $headers = [];

        /**
         * @var int $timeout
         */
        private $timeout = 15;

        /**
         * @var bool $sslCertificate
         */
        private $sslCertificate = false;

        /**
         * Set request headers.
         * 
         * @param array $headers 
         * @return self
         */
        public function withHeaders(array $headers): self 
        {
            $this->headers = $headers;
            return $this;
        }

        /**
         * Set request authorization header 
         * with Bearer token.
         * 
         * @param string $token 
         * @return self
         */
        public function withToken(string $token): self
        {
            $this->headers['Authorization'] = 'Bearer '.$token;
            return $this;
        }

        /**
         * Set timeout.
         * 
         * @param int $timeout 
         * @return self
         */
        public function withTimeout(int $timeout): self
        {
            $this->timeout = $timeout;
            return $this;
        }

        /**
         * Set check SSL certificate.
         * 
         * @param bool $sslCertificate 
         * @return self
         */
        public function withSslCertificate(bool $sslCertificate): self 
        {
            $this->sslCertificate = $sslCertificate;
            return $this;
        }

        /**
         * GET 
         * 
         * @param string $uri 
         * @return ResponseInterface
         */
        public function get(string $uri): ResponseInterface
        {
            $request = new Request('GET', $uri);
            return $this->sendRequest($request);
        }

        /**
         * POST 
         * 
         * @param string $uri 
         * @param array $data
         * @return ResponseInterface
         */
        public function post(string $uri, array $data = []): ResponseInterface
        {
            $body = $this->encode($data);
            $request = new Request('GET', $uri, [], $body);
            return $this->sendRequest($request);
        }

        /**
         * PUT 
         * 
         * @param string $uri 
         * @param array $data
         * @return ResponseInterface
         */
        public function put(string $uri, array $data = []): ResponseInterface
        {
            $body = $this->encode($data);
            $request = new Request('PUT', $uri, [], $body);
            return $this->sendRequest($request);
        }

        /**
         * PATCH 
         * 
         * @param string $uri 
         * @param array $data
         * @return ResponseInterface
         */
        public function patch(string $uri, array $data = []): ResponseInterface
        {
            $body = $this->encode($data);
            $request = new Request('PATCH', $uri, [], $body);
            return $this->sendRequest($request);
        }

        /**
         * DELETE 
         * 
         * @param string $uri 
         * @param array $data
         * @return ResponseInterface
         */
        public function delete(string $uri, array $data = []): ResponseInterface
        {
            $body = $this->encode($data);
            $request = new Request('DELETE', $uri, [], $body);
            return $this->sendRequest($request);
        }

        /**
         * Encode array. 
         *  
         * @param array $data
         * @return string
         */
        private function encode(array $data) : string
        {
            return json_encode($data) !== false ? json_encode($data) : '';
        }

        /**
         * Send request.
         * 
         * @param RequestInterface $request
         * @return ResponseInterface
         */
        private function sendRequest(RequestInterface $request): ResponseInterface 
        {
            foreach ($this->headers as $name => $value) {
                $request = $request->withHeader($name, $value);
            }
            $client = new Client($this->timeout, $this->sslCertificate);
            return $client->sendRequest($request);
        }
    }