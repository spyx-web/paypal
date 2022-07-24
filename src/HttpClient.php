<?php

namespace Szwtdl\Paypal;

use GuzzleHttp\Client;
use Szwtdl\Paypal\Request\AccessToken;

class HttpClient
{
    protected Client $client;
    protected string $client_id;
    protected string $client_key;
    protected string $mode = 'dev';
    protected array $options = [];

    protected array $url = [
        'dev' => 'https://api-m.sandbox.paypal.com',
        'prod' => 'https://api-m.paypal.com'
    ];

    public function __construct($client_id, $client_key, $mode = 'dev')
    {
        $this->client_id = $client_id;
        $this->client_key = $client_key;
        $this->mode = $mode;
        $this->client = new Client(['base_uri' => $this->url[$this->mode], 'timeout' => 3.0]);
    }

    /**
     * @return mixed|string
     */
    public function getMode(): mixed
    {
        return $this->mode;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param mixed|string $mode
     */
    public function setMode(mixed $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function execute(RequestInterface $request)
    {
        return $this->client->request(
            $request->getMethod(),
            $request->getPath(),
            $request->getParams()
        );
    }

    /**
     * 获取access_token
     * @return mixed
     * @throws \Exception
     */
    public function getAccessToken()
    {
        try {
            $request = new AccessToken();
            $request->setParams([
                'auth' => [$this->client_id, $this->client_key],
                'form_params' => ['grant_type' => 'client_credentials']
            ]);
            $result = $this->execute($request)->getBody()->getContents();
            return \json_decode($result, true)['access_token'];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}