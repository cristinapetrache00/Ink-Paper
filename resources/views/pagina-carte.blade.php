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
    <book-details class="margin-main" :book="{{ $data }}"></book-details>
</div>

</body>

<script src="{{ mix('js/app.js') }}"></script>

<style>
    body{
        padding: 0;
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
        background-color: #22223b;
        /*border-radius: 10px;*/
    }

    /* This styles the scrollbar thumb */
    ::-webkit-scrollbar-thumb {
        background-color: #aaa;
        /*border-radius: 10px;*/
        border: 3px solid #888888;
    }

    /* This styles the scrollbar thumb when it's being hovered over */
    ::-webkit-scrollbar-thumb:hover {
        background-color: #888888;
    }

    /* This styles the scrollbar corner */
    ::-webkit-scrollbar-corner {
        background-color: #0a53be;
    }

    /* This styles the scrollbar when it's in a horizontal orientation */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
</style>
