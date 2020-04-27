<?php   

namespace App;

use App\Fetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Promise\EachPromise;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class VideoUploader
{
    public function downloadVideos($skus)
    {
        $promises = $this->fetchProductsFromApi($skus);
        
        $eachPromise = new EachPromise($promises, [
            'concurrency' => 4,
            'fulfilled' => function (Response $response) {
                if ($response->getStatusCode() == 200) {
                    $product = json_decode($response->getBody(), true);
                    $this->grabVideoFromResponse($product);
                }
            },
            'rejected' => function ($reason) {
                dump($reason);
            }
        ]);

        $eachPromise->promise()->wait();
    }

    protected function fetchProductsFromApi($skus)
    {
        $client = new Client([
            'base_uri' => '',
            'headers' => [
                'Apikey' => ''
            ]
        ]);

        $promises = (function () use ($skus, $client) {
            foreach ($skus as $sku) {
                // don't forget using generator
                yield $client->getAsync('/api/v1/invicta/models_no/'. $sku .'/media');
            }
        })();

        return $promises;
    }

    protected function grabVideoFromResponse($product)
    {
        if (isset($product['result']) && $product['count'] > 0) {
            foreach ($product['result'] as $item) {
                if ($item['media_type'] === '360 Videos') {
                    $this->download($item['media_url'], $item['product_model_no'], $item['extension']);
                }
            }
        }
    }

    protected function download($url, $model, $extension)
    {
        $client = new Client();
        $promise = $client->getAsync($url, [
            'sink' => __DIR__ . '/downloads/' . $model . '.' . $extension
        ]);

        $promise->then(
            function (ResponseInterface $res) {
                echo $res->getStatusCode() . "\n";
            },
            function (RequestException $e) {
                echo $e->getMessage() . "\n";
                echo $e->getRequest()->getMethod();
            }
        );

        $promise->wait();
    }
}