<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/css/app.css')
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialiased">
       <div id="app">
       </div>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.js" integrity="sha512-h6jMQVe4ZSgg9X9qOG/SJc4UONainRB8u370amzB/83Vcd6Si9iI4hOGns3W+SH+/XShLDFmnoWQKj3bt3Ql4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       @vite('resources/js/app.js')

    </body>
</html>
