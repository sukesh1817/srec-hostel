<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400");
        @import url("https://fonts.googleapis.com/css?family=Playfair+Display");

        body,
        .img,
        .form,
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        body {
            height: 100vh;
            background: #e8e8e8;
            font-family: "Source Sans Pro", sans-serif;
            overflow: hidden;
        }

        .container {
            width: 700px;
            height: 400px;
            background: white;
            position: relative;
            display: grid;
            grid-template: 100%/50% 50%;
            box-shadow: 2px 2px 10px 0 rgba(51, 51, 51, 0.2);
        }

        .img {
            background-image: url("/images/layout-image/complaint.jpg") !important;
            position: absolute;
            width: 50%;
            height: 100%;
            transition: 0.5s all ease;
            transform: translateX(100%);
            z-index: 4;
        }

        .img:before {
            position: absolute;
            content: "";
            width: 1px;
            height: 70%;
            background: #c3c3d8;
            opacity: 0;
            left: 0;
            top: 15%;
        }



        .img-container:before {
            opacity: 0.3;
            left: 0;
        }

        .login:before {
            opacity: 0.3;
            left: 100%;
        }

        .btn-wrapper {
            width: 60%;
        }

        .form {
            width: 100%;
            height: 100%;
        }

        .form--heading {
            font-size: 25px;
            height: 50px;
            color: black;
            font-family: "Source Sans Pro", sans-serif;
        }

        .form--committe {
            border-right: 1px solid #999;
        }

        form {
            width: 70%;
        }

        form>* {
            margin: 10px;
        }

        form input {
            width: 90%;
            height: 50%;
            border: 0;
            border-bottom: 1px solid #aaa;
            /* font-size: 13px;
            font-weight: 300; */
            color: #797a9e;
            /* letter-spacing: 0.11em; */
        }

        form select {
            width: 90%;
            height: 50%;
            border: 0;
            border-bottom: 1px solid #aaa;
            /* font-size: 13px;
            font-weight: 300; */
            color: black;
            /* letter-spacing: 0.11em; */
        }

        form input::placeholder {
            color: black;
            /* font-size: 10px; */
        }

        form input:focus {
            outline: 0;
            border-bottom: 1px solid rgba(128, 155, 206, 0.7);
            transition: 0.6s all ease;
        }

        form select:focus {
            outline: 0;
            border-bottom: 1px solid rgba(128, 155, 206, 0.7);
            transition: 0.6s all ease;
        }

        option {
            border-radius: 1px;
        }

        .button {
            width: 90%;
            border-radius: 1px;
            outline: 0;
            color: white;
            font-size: 15px;
            font-weight: 400;
            position: relative;
            cursor: pointer;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="img img-container">

        </div>
        <div class="form form--committe">
            <div class="form--heading">Welcome, Fill the form !</div>
            <form autocomplete="off">
                <input type="number" placeholder="Roll no" required>
                <select name="which-committe" id="which-committe" required>
                    <option class="text-dark" value="" selected>Which committe</option>
                    <option value="sports">Sports</option>
                    <option value="library">Library</option>
                    <option value="garden">Garden</option>
                    <option value="wifi">Wifi</option>
                </select>
                <button class="btn btn-dark button">check and submit</button>
            </form>
        </div>

    </div>
</body>

</html>