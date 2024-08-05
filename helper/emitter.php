<?php

use Psr\Http\Message\ResponseInterface;

/**
 *  Emits response stream
 *  Copied from http-interop/response-sender on GitHub
 * 
 *  @param ResponseInterface $response
 *  
 *  @return void
 **/
function emit(ResponseInterface $response) {
    $httpLine = sprintf(
        'HTTP/%s %s %s',
        $response->getProtocolVersion(),
        $response->getStatusCode(),
        $response->getReasonPhrase()
    );

    header($httpLine, true, $response->getStatusCode());

    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header("$name: $value", false);
        }
    }

    $stream = $response->getBody();

    if ($stream->isSeekable()) {
        $stream->rewind();
    }

    while (!$stream->eof()) {
        echo $stream->read(1024 * 8);
    }
}
