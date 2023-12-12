<?php 

namespace App\Util;

use SplFileObject;
use phpseclib3\Net\SFTP;


class ToolKit{
    public static function uploadFileViaFtp($ftpServer,$port,$ftpUsername,$ftpPassword,SplFileObject $file,$remotePath){
     
        
        try {
            $ftpConnection = ftp_connect($ftpServer.":".$port);
        } catch (\Exception $exception) {  
            throw new \Exception('Impossible de se connecter au serveur FTP');
        }

        try {
            ftp_login($ftpConnection, $ftpUsername, $ftpPassword);
        } catch (\Exception $exception) {   
            throw new \Exception('Veuillez verifier les informations de connexion au serveur');
        }
        

        $flags = $file->getFlags();
        $fileHandle = fopen($file->getRealPath(), ($flags & SplFileObject::DROP_NEW_LINE) ? 'r' : 'r+');


        try {
            ftp_fput($ftpConnection, $remotePath, $fileHandle, FTP_BINARY);
        } catch (\Throwable $th) {
            throw new \Exception('Il y a eu une erreur lors de l\'envoi du fichier vers le serveur FTP');
        }

        ftp_close($ftpConnection);
        return true;
    }


    public static function uploadFileViaSftp($ftpServer,$port,$ftpUsername,$ftpPassword,SplFileObject $file,$remotePath){
      
        $sftp = new SFTP($ftpServer,$port);
        try{
            if (!$sftp->login($ftpUsername, $ftpPassword)) {
                throw new \Exception('');
            }
        } catch (\Throwable $th) {
            throw new \Exception('Impossible de se connecter au serveur FTP');
        }

        $flags = $file->getFlags();
        $fileHandle = fopen($file->getRealPath(), ($flags & SplFileObject::DROP_NEW_LINE) ? 'r' : 'r+');

    
        if (!$sftp->put($remotePath, $fileHandle, SFTP::SOURCE_LOCAL_FILE)) {
            $sftp->disconnect();
            throw new \Exception('Il y a eu une erreur lors de l\'envoi du fichier vers le serveur FTP');
        } 
       
        $sftp->disconnect();
        return true;
    }


    public static function generateFileName(string $extension): string {
        if(empty($extension)){
            throw new \Exception('Veuillez fournir une extension valide');
        }
        $date = (new \DateTime())->format('Ymd_His');
        return $_ENV['FILE_NAME_PREFIX'].$date.".".$extension;
    }
}