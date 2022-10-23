<?php

namespace Study\UrlCompressor\Helpers;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class CheckUrl
{
    protected ClientInterface $httpClient;
    private int $timeout;
    private array $statusCodes;
    private string $userAgent;
    public string $checkedUrl;
    public bool $urlType;

    public function __construct(ClientInterface $httpClient, int $timeout, array $statusCodes, string $userAgent)
    {
        $this->httpClient = $httpClient;
        $this->timeout = $timeout;
        $this->statusCodes = $statusCodes;
        $this->userAgent = $userAgent;
        $this->urlType = false;
        $this->checkedUrl = $this->CheckInput();
        $responseCode = $this->GetRequest();
        $this->ValidateResponse($responseCode);
    }

    private function CheckInput(): string
    {
        do {
            $input = readline('Введіть корректний URL: ');
        } while (!filter_var($input, FILTER_VALIDATE_URL));
        return $input;
    }

    private function GetRequest(): int
    {
        try {
            $requestResult = $this->httpClient->request('GET', $this->checkedUrl, [
                'headers' => [
                    'User-Agent' => $this->userAgent,
                ],
                'timeout' => $this->timeout
            ]);
            $responseCode = $requestResult->getStatusCode();
        } catch (GuzzleException $e) {
            $responseCode = 0;
        }
        return $responseCode;
    }

    private function ValidateResponse(int $code): void
    {
        if (isset($this->statusCodes[$code]))
            $this->urlType = true;
    }
}
