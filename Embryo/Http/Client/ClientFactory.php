<?php 

    namespace Embryo\Http\Client;

    use Embryo\Http\Message\Request;
    use Psr\Http\Message\ResponseInterface;

    class ClientFactory 
    {
        /**
         * @var array $allowedMethods
         */
        private $allowedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

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

        public function withHeaders(array $headers): self 
        {
            $this->headers = $headers;
            return $this;
        }

        public function withToken(string $token): self
        {
            $this->headers['Authorization'] = 'Bearer '.$token;
            return $this;
        }

        public function withTimeout(int $timeout): self
        {
            $this->timeout = $timeout;
            return $this;
        }

        public function withSslCertificate(bool $sslCertificate): self 
        {
            $this->sslCertificate = $sslCertificate;
            return $this;
        }

        /**
         * @param string $method
         * @param array $arguments 
         * @return ResponseInterface
         */
        public function __call(string $method, $arguments): ResponseInterface
        {   
            $method = strtoupper($method);
            if (!in_array($method, $this->allowedMethods)) {
                throw new \InvalidArgumentException("Invalid HTTP method: '{$method}'");
            }

            $uri = $arguments[0];
            $data = isset($arguments[1]) ? $arguments[1] : [];
            $body = json_encode($data) ? json_encode($data) : '';

            $request = new Request($method, $uri, [], $body);
            foreach ($this->headers as $name => $value) {
                $request = $request->withHeader($name, $value);
            }

            $client = new Client($this->timeout, $this->sslCertificate);
            return $client->sendRequest($request);
        }
    }