<?php

namespace App\Services;

use SplFileObject;
use App\Util\GenericUtil;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExcelService
{

    public const SEPARATOR = ";";
    public const EXPORT_FILE_NAME = "export.csv";

    public function __construct(
        private TranslatorInterface $translator,
    ){

    }

    public function export($data, array $fields, array $headers): ?SplFileObject
    {
        $file = new SplFileObject(ExcelService::EXPORT_FILE_NAME, "w");
        $file->fputcsv(ExcelService::to_utf8($headers), ExcelService::SEPARATOR);
        foreach($data as $obj){
            $row = [];
            foreach($fields as $field){
                $value = GenericUtil::getPropertyValue($obj, $field);
                $row[] = $value;
            }
            $file->fputcsv(ExcelService::to_utf8($row), ExcelService::SEPARATOR);
        }
        return $file;
    }

    public function getrowsInTable(array $data, array $fields)
    {
        $table = [];
        $headers = ["NOM ET PRÉNOMS", "EMAIL", "TÉLÉPHONE", "ADRESSE", "TYPE DU LOGEMENT", "RUE", "NUMÉRO", "CODE POSTAL", "VILLE", "COMPOSITION DU FOYER", "NOMBRE DE PERSONNE"];
        $table[] =  $headers;
      
        foreach($data as $obj){
            $row = [];
            foreach($fields as $field){
                $value = GenericUtil::getPropertyValue($obj, $field);
                if ($value === null) {
                    $value = ' ';
                }else{
                    $value = $value;
                }
                // $value = utf8_decode($value);
                $row[] = $value;
            }
            // dd($row);
                        
            $table[] = $row;
        }
        
        return $table;
    }

    public static function to_utf8(array $tab): ?array
    {
        return array_map("utf8_decode", $tab);
    }

    public function exportXlsx($data, array $fields, array $headers){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $col = 'A'; 
        foreach ($headers as $header) {
            $header = $this->translator->trans($header);
            $sheet->setCellValue($col . '1', $header);
            $col = $this->incrementColumn($col); 
        }
        
   
        $row = 2;
        foreach ($data as $item) {
            $col = 'A'; 
            foreach ($fields as $field) {
                $value = GenericUtil::getPropertyValue($item, $field);
                if (is_string($value) && trim($value) !== '') {
                    $value = $this->translator->trans($value);
                }
                $sheet->setCellValue($col . $row,$value ?? ''); 
                $col = $this->incrementColumn($col); 
            }
            $row++;
        }

        return $spreadsheet;
    }

    function incrementColumn($col)
    {
        $lastChar = substr($col, -1);
        $rest = substr($col, 0, -1);

        if ($lastChar == 'Z') {
            $col = $rest . 'A';  // Reset the last letter to 'A' and increment the previous part
        } else {
            $col = $rest . chr(ord($lastChar) + 1);  // Increment the last letter
        }

        return $col;
    }

}