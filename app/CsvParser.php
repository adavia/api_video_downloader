<?php   

namespace App;

class CsvParser
{
    protected $file;

    public function __construct($file)      
    {
        $this->file = $file;
    }

    public function read()
    {
        $products = [];

        if (($h = fopen("{$this->file}", "r")) !== false) {
            while (($data = fgetcsv($h, 1000, ",")) !== false) {
                // Each individual array is being pushed into the nested array
                if ($data[0] === 'sku') continue;
                $products[] = $data[0];
            }

            // Close the file
            fclose($h);
        }

        return $products;
    }
}