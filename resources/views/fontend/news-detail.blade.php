<html>
   <head>
      <title>{{ $news_title }}</title>
      <link href = "https://fonts.googleapis.com/css?family=Arial:100" rel = "stylesheet" type = "text/css">
      <style>
         html, body {
            height: 100%;
         }
         body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Arial';
         }
         .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
         }
         .content {
            text-align: center;
            display: inline-block;
         }
         .title {
            font-size: 96px;
         }
      </style>
   </head>
   <body>
      <div class = "container">
         <div class = "content">
            <h1>{{ $news_title }}</h1>
            <p>
               ID bài viết: {{ $news_id }}
               <br> Tiêu đề: {{ $news_title }}
               <br> Nội dung: Chưa có nội dung gì cả
            </p>
         </div>
      </div>
   </body>
</html>