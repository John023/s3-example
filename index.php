<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <style>
      table { border-collapse: collapse; border-spacing: 0; width: 100%; border: 1px solid #ddd; }
      th, td { text-align: left; padding: 16px; }
      tr:nth-child(even) { background-color: #f2f2f2; }
   </style>
</head>
<body>
   <br>
   <table>
      <thead>
         <tr>
            <th>Key</th>
            <th>Bucket</th>
            <th>Tamaño</th>
            <th>Fecha</th>
            <th>Descargar</th>
         </tr>
      </thead>
      <tbody id="content"></tbody>
   </table>
   <br>

   <form method="post" id="uploadFile" enctype="multipart/form-data">
      <input type="file" name="file">
      <input type="submit" name="submit" value="Upload">
   </form>
</body>

<script type="text/javascript">

   $(document).ready(function(e){
      $.ajax({
         url: "s3.php",
      }).done(function(data) {
         $("#content").append(data);
         // console.log(data);
      });
   });

   $('#uploadFile').on('submit', function(e){
      e.preventDefault();
      
      $.ajax({
         url: "s3.php",
         method: "POST",
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         success:function(data)
         {
            console.log(data);

            // $('#uploaded_image').html(data);
         }
      });
   });


   function getFile(key) {
      $.ajax({
         url: "s3.php",
         method: "POST",
         data: { key: key },
         success:function(data)
         {
            alert('File downloaded');
            // alert(data);
         }
      });
   }


   // let form = document.getElementById('uploadFile');

   // form.addEventListener('submit', function(e) {
   //    e.preventDefault();
   //    // console.log(form.elements.file.value);

   //    var formData = new FormData(form)[0];
   //    var xhr = new XMLHttpRequest();
   //    xhr.open('POST', 's3.php', true);
   //    xhr.onload = function() {
   //       if (xhr.status === 200) {
   //          console.log(xhr);
   //       }
   //    };
   //    xhr.send(formData);
   //    // e.preventDefault();
   // });

   // https://aws.amazon.com/es/articles/aws-sdk-for-php-tips-and-tricks/?tag=articles%23keywords%23php

</script>

</html>