<?php

// print_r($_FILES);

require_once 'vendor/autoload.php';

use Aws\S3\S3Client;
// use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$datosS3 = [
   'Test' => [
      'Bucket' => 'test-anexos',
      'version' => 'latest',
      'region'  => 'us-east-1',
      'credentials' => [
         'key'    => 'AKIA5VR3FW5CIE65FV6I',
         'secret' => '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'
      ],
   ],
   'Min' => [
      'Bucket' => 'minambiente-negociosverdes',
      'version' => 'latest',
      'region'  => 'us-east-1',
      'credentials' => [
         'key'    => 'AKIA5P5FVJFMN7DNJ35Y',
         'secret' => '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'
      ],
   ],
];

$S3Options = [
   'version' => 'latest',
   'region'  => 'us-east-1',
   'credentials' => [
      'key'    => $datosS3['Test']['credentials']['key'],
      'secret' => $datosS3['Test']['credentials']['secret'],
   ]
];

$s3Client = new S3Client($S3Options);


/*=====================
Listar arquivos
=====================*/

$files = $s3Client->listObjects([
   'Bucket' => $datosS3['Test']['Bucket'],
]);

$files = $files->toArray();

$row = "";

foreach ($files['Contents'] as $file) {
   $row .= "<tr><td>{$file['Key']}</td>";
   $row .= "<td>test</td>";
   $row .= "<td>{$file['Size']}</td>";
   $row .= "<td>{$file['LastModified']}</td>";
   $row .= "<td><button onclick='getFile(&#34;{$file['Key']}&#34;)'>Download</button></td></tr>";
}

// $files = $files->get('Contents');

echo $row;
// print_r($row);


/*=====================
Upload files
=====================*/

if (isset($_FILES['file']) && !empty($_FILES['file'])) {

   $fileName = $_FILES['file']['name'];
   $file_path = $_FILES['file']['tmp_name'];

   try {
      $result = $s3Client->putObject([
         'Bucket' => $datosS3['Test']['Bucket'],
         'Key'    => 'business_images/' . $fileName,
         'SourceFile' => $file_path,
      ]);
      // 'ACL'    => 'public-read'

      // echo '<img src="' . $result['ObjectURL'] . '" />';
      echo "<pre>" . print_r($result, true) . "</pre>";

   } catch (S3Exception $th) {
      echo $th->getMessage() . "\n";
   }
}


/*=====================
Download files
=====================*/

if (isset($_POST['key'])) {

   $key = $_POST['key'];

   try {
      $result = $s3Client->getObject([
         'Bucket' => $datosS3['Test']['Bucket'],
         'Key'    => $key,
      ]);

      $getFile = $result->toArray();

      // print_r($getFile['Body']);
      file_put_contents('downloads/' . $key, $getFile['Body']);

      // header("Content-Type: {$result['ContentType']}");
      // echo $result['Body'];

   } catch (S3Exception $th) {
      echo $th->getMessage() . "\n";
   }
}
