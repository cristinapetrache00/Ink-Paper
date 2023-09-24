<!DOCTYPE html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<html>
<head>
    <title>Ink&Paper</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <navigation class="padding-main"></navigation>
        <log-in></log-in>
    </div>
</body>

<script src="{{ mix('js/app.js') }}"></script>

<style>

    body {
        margin: 0;
        padding: 0;
        font-family: 'Lora',serif;
        /*background: #eaf3fa;*/
        /*background: #e8e5df;*/
        background: #EDF6F6;
    }

    .margin-main {
        margin-left: calc(50% - 675px);
        margin-right: calc(50% - 675px);
    }
    .padding-main {
        padding-left: calc(50% - 645px);
        padding-right: calc(50% - 655px);
    }

    ::-webkit-scrollbar-track {
        background-color: #F0F1F2;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #00A896;
        border: 3px solid #00A896;
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #00A896;
    }

    ::-webkit-scrollbar-corner {
        background-color: #00A896;
    }
</style>

<title> Log In </title>

