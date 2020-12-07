<?php 

    /**
     * RequestException
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-client 
     */

    namespace Embryo\Http\Client\Exceptions;

    use Psr\Http\Client\RequestExceptionInterface;
    use Psr\Http\Message\RequestInterface;

    class RequestException extends \RuntimeException implements RequestExceptionInterface
    {
        /**
         * @var RequestInterface $request
         */
        private $request;

        /**
         * Set exception.
         * 
         * @param string $message
         * @param RequestInterface $request
         * @param \Exception|null $previous
         */
        public function __construct(string $message, RequestInterface $request, \Exception $previous = null)
        {
            $this->request = $request;
            parent::__construct($message, 0, $previous);
        }

        /**
         * Get request.
         * 
         * @return RequestInterface
         */
        public function getRequest(): RequestInterface
        {
            return $this->request;
        }
    }