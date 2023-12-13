<?php

namespace App\Services;

use SplFileObject;
use App\Entity\Pack;
use App\Entity\Order;
use App\Entity\OrderPack;
use App\Entity\OrderPackProduct;
use App\Util\GenericUtil;
use App\Entity\OrderProduct;
use App\Entity\PackProduct;

class SpreadsheetService
{
    
    const SEPARATOR = ";";
    const DECIMAL_SEPARATOR = ".";
    const EXPORT_FILE_NAME = "exportOrder.csv";


    public function export($data, array $fields, array $headers, array $options = []): ?SplFileObject
    {
        $file = new SplFileObject(SpreadsheetService::EXPORT_FILE_NAME, "w");
        $file->fputcsv($headers, self::SEPARATOR);
        foreach($data as $obj){
            $row = [];
            $productsInOrder = [];
            $isRepeatable = false;

            foreach($fields as $row_field){
                $value = $row_field ? GenericUtil::getPropertyValue($obj, $row_field) : null;
                $value = $this->convertStringToNumeric($options, $row_field, $value);   
                if ($this->isRepeatableByRefProduct($options, $row_field, $value)) {
                    $productsInOrder = $this->nbrRepeatRowByRefProduct($options, $value, $row_field); 
                    $isRepeatable = true;
                    $value = 'refProdToChange';   
                }
                $row[] = $value;
            }
            $originalRow = $row;

            if ($isRepeatable === true) {  
                /** @var OrderProduct $product */
                foreach ($productsInOrder as $productOrder) {
                    for ($i=0; $i < count($row); $i++) { 
                        $row[$i] === OrderPack::TO_CHANGE['refProd'] && $row[$i] =  $productOrder->getProduct()->getReferenceSKU();
                        $row[$i] === OrderPack::TO_CHANGE['quantity'] && $row[$i] =  $productOrder->getQty();
                        $row[$i] === OrderPack::TO_CHANGE['amount'] && $row[$i] =  number_format($productOrder->getPrice(), 2, self::DECIMAL_SEPARATOR, '') ;
                    }

                    $file->fputcsv($row, self::SEPARATOR);
                    $row = $originalRow;
                }                 
                $productsInOrder = 0;
                $isRepeatable = false;
            }else{
                for ($i=0; $i < count($row); $i++) { 
                    if (is_array($row[$i]) &&  $row[$i][0] instanceof OrderProduct) {
                        $row[$i] = $row[$i][0]->getProduct()->getReferenceSKU();
                    }
                }
                $file->fputcsv($row, self::SEPARATOR);
            }
        }
        return $file;
    }



    public function exportOrderPack($data, array $fields, array $headers, array $options = []): ?SplFileObject
    {
        //$data = $orderPack->getPack()->getProducts()->toArray();
        $file = new SplFileObject(SpreadsheetService::EXPORT_FILE_NAME, "w");
        $file->fputcsv($headers, self::SEPARATOR);
        foreach($data as $obj){
            $row = [];
            $productsInOrder = [];
            $isRepeatable = false;
            foreach($fields as $row_field){
                $value = $row_field ? GenericUtil::getPropertyValue($obj, $row_field) : null;
                $value = $this->convertStringToNumeric($options, $row_field, $value);   
                if ($this->isRepeatableByRefProduct($options, $row_field, $value)) {
                    $productsInOrder = $this->nbrRepeatRowByRefProduct($options, $value, $row_field); 
                    $isRepeatable = true;
                    $value = 'refProdToChange';   
                }
                $row[] = $value;
                
            }
            $originalRow = $row;

            if ($isRepeatable === true) {  
                /** @var OrderProduct $product */
                foreach ($productsInOrder as $productOrder) {
                    for ($i=0; $i < count($row); $i++) { 
                        $row[$i] === OrderPack::TO_CHANGE['refProd'] && $row[$i] =  $productOrder->getProduct()->getId();
                        $row[$i] === OrderPack::TO_CHANGE['quantity'] && $row[$i] =  $productOrder->getQty();
                        $row[$i] === OrderPack::TO_CHANGE['amount'] && $row[$i] =  number_format($productOrder->getPrice(), 2, self::DECIMAL_SEPARATOR, '') ;
                    }

                    $file->fputcsv($row, self::SEPARATOR);
                    $row = $originalRow;
                }                 
                $productsInOrder = 0;
                $isRepeatable = false;
            }
            // for ($i=0; $i < count($row); $i++) { 
            //     if ($row[$i] instanceof PackProduct) {
            //         $row[$i] = $row[$i]->getName();
            //     }
            // }
            else{
                // for ($i=0; $i < count($row); $i++) { 
                //     if (is_array($row[$i]) &&  $row[$i][0] instanceof OrderPackProduct) {
                //         $row[$i] = $row[$i][0]->getProduct()->getId();
                //     }
                // }
                // try{
                $file->fputcsv($row, self::SEPARATOR);
                // }catch(\Exception $ex){dd($row);}
            }
        }
        return $file;
    }



    public static function to_utf8(array $tab): ?array
    {  
        return array_map("utf8_decode", $tab);
    }

    public function convertStringToNumeric(array $options, $row_field, $value_to_convert)
    {
        $keys_options = array_keys($options);
        foreach ($options['convert_string_to_numeric']['fields'] as $verif_field) {     
            if (!empty($options) && in_array('convert_string_to_numeric', $keys_options) && $row_field === $verif_field && $value_to_convert !== OrderPack::TO_CHANGE['amount']) {
                return number_format($value_to_convert, 2, self::DECIMAL_SEPARATOR, '');
            }else{
                return $value_to_convert;
            }
        }
      
    }


    public function isRepeatableByRefProduct($options, $row_field, $productsInOrder)
    {
        $keys_options = array_keys($options);
        
        if (!empty($options) && in_array('repeat_row', $keys_options) && $options['repeat_row']['field'] === $row_field ) {
            return true;
        }else{
            return false;
        }
    }


    public function nbrRepeatRowByRefProduct($options, $value, $row_field)
    {        
        if (!empty($options) && $options['repeat_row']['field'] === $row_field) {
            return $value;
        }
    }
}
