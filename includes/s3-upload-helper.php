<?php

require "../vendor/autoload.php";

use Aws\S3\S3Client;

use Aws\Exception\AwsException;


if(isset($_POST['s3-submit'])){
    $bucketName = "jaketay-s3";

    $file = $_FILES['s3-image'];
    $file_name = $_FILES['name'];
    $file_tmp_name = $_FILES['tmp_name'];
    $file_error = $_FILES['error'];
    $file_size = $_FILES['size'];

    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    try{
        $s3Client = S3Client::factory(
            array('region'=>'us-east-1',
            'version'=>'latest',
            'credentials'=> array(
                'key' => 'AKIAQEXZBDAOYJP75GUP',
                'secret' => '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'

            ))
            );
        $result = $s3Client->putObject([

            'Bucket'=>$bucketName,
            'Key'=> 'test_uploasds/'.uniqid('',true).'.'.$ext,
            'SourceFile'=>$file_tmp_name,
            'ACL'=>'public-read'
        ]);

        echo "Success! Photo URL: ".$result->get('ObjectUrl');

    } catch(Aws\S3\Exception\S3Exception $e){
        die('Error Uploading File: '.$e->getMessage());
    }
    
}