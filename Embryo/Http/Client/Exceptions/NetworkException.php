<?php 

    /**
     * NetworkException
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-client 
     */

    namespace Embryo\Http\Client\Exceptions;

    use Psr\Http\Client\NetworkExceptionInterface;

    final class NetworkException extends RequestException implements NetworkExceptionInterface {}