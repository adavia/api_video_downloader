<?php

require 'vendor/autoload.php';

use App\CsvParser;
use App\VideoUploader;

$csv = new CsvParser('test.csv');
$skus = $csv->read();

$uploader = new VideoUploader();
$uploader->downloadVideos($skus);

//curl --request POST --url https://api.sirv.com/v2/files/fetch --header 'authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRJZCI6Ik5rVUpEVzVEQ0RDQmVtN3dCejJ2RHlFWkxOcSIsImNsaWVudE5hbWUiOiJJbnZpY3RhIHdhdGNoIEFQSSIsInNjb3BlIjpbImFjY291bnQ6cmVhZCIsImFjY291bnQ6d3JpdGUiLCJ1c2VyOnJlYWQiLCJ1c2VyOndyaXRlIiwiYmlsbGluZzpyZWFkIiwiYmlsbGluZzp3cml0ZSIsImZpbGVzOnJlYWQiLCJmaWxlczp3cml0ZSIsImZpbGVzOnVwbG9hZDptdWx0aXBhcnQiLCJ2aWRlb3MiLCJpbWFnZXMiXSwiaWF0IjoxNTg3MTI5NzU1LCJleHAiOjE1ODcxMzA5NTUsImF1ZCI6InFtbzB6bGJwM21maXVycDFzdHNuemxpamR4NGkzaGJ3In0.ZKwyNHJqYNTsMO5QBvyGSoMN5uIgPHnWobmLWTYf9nE' --header 'content-type: application/json' --data '{"auth": {"username": "adavia@invictastores.com", "password": "Invicta2020"}, "url": "https://cdn.invictawatch.com/media/201204/113935_360video.mp4", "filename": "/media/201204.mp4"}'
