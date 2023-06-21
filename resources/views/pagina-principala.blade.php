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
    <navigation></navigation>
</div>
</body>

<script>
</script>

<script src="{{ mix('js/app.js') }}">
    export default {
        data() {
            return {
                emittedData: null
            };
        },
        methods: {
            handleData(filtered) {
                this.emittedData = filtered;
            }
        }
    }
</script>

<style>
    body{
        background-color: #FAFAFA;
        margin:0;
        padding: 0;
    }
</style>
