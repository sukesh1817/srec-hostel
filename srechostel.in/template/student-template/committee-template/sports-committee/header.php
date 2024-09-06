<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leader Information</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";

  ?>
  <style>
    .container {
      width: 100%;
    }

    .profile-picture img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .profile-picture {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-end;
      margin-top: 25%;
    }

    .profile-picture h3 {
      font-size: 16px;
      font-weight: 500;
      margin-top: 5px;
    }

    h4 {
      font-weight: 500;
    }

    .comment-box input {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
      margin-bottom: 10px;
    }

    .submit-btn {
      margin-top: 10px;
      background-color: #000;
      color: #fff;
      border: none;
      padding: 10px 15px;
      cursor: pointer;
      border-radius: 5px;
      width: 100%;
    }

    .labels {
      font-size: 14px;
      font-weight: 500;
      color: #555;
      text-align: left;
    }

    .details {
      font-size: 16px;
      font-weight: 400;
    }

    .achievements {
      margin-top: 20px;
    }

    .achievements h2 {
      margin-bottom: 20px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
      gap: 20px;
    }

    .grid img {
      width: 100%;
      border-radius: 10px;
      transition: transform 0.3s;
    }

    .grid img:hover {
      transform: scale(1.05);
    }

    @media (min-width: 768px) {
      .grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    @media (max-width: 767px) {
      .grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    .rating {
      display: flex;
      justify-content: center;
      flex-direction: row-reverse;
      gap: 0.3rem;
      --stroke: #666;
      --fill: #ffc73a;
    }

    .rating input {
      appearance: unset;
    }

    .rating label {
      cursor: pointer;
    }

    .rating svg {
      width: 2rem;
      height: 2rem;
      overflow: visible;
      fill: transparent;
      stroke: var(--stroke);
      stroke-linejoin: bevel;
      stroke-dasharray: 12;
      animation: idle 4s linear infinite;
      transition: stroke 0.1s, fill 0.5s;
    }

    @keyframes idle {
      from {
        stroke-dashoffset: 24;
      }
    }

    .rating label:hover svg {
      stroke: var(--fill);
    }

    .rating input:checked~label svg {
      transition: 0s;
      animation: idle 4s linear infinite, yippee 0.75s backwards;
      fill: var(--fill);
      stroke: var(--fill);
      stroke-opacity: 0;
      stroke-dasharray: 0;
      stroke-linejoin: miter;
      stroke-width: 8px;
    }

    @keyframes yippee {
      0% {
        transform: scale(1);
        fill: var(--fill);
        fill-opacity: 0;
        stroke-opacity: 1;
        stroke: var(--stroke);
        stroke-dasharray: 10;
        stroke-width: 1px;
        stroke-linejoin: bevel;
      }

      30% {
        transform: scale(0);
        fill: var(--fill);
        fill-opacity: 0;
        stroke-opacity: 1;
        stroke: var(--stroke);
        stroke-dasharray: 10;
        stroke-width: 1px;
        stroke-linejoin: bevel;
      }

      30.1% {
        stroke: var(--fill);
        stroke-dasharray: 0;
        stroke-linejoin: miter;
        stroke-width: 8px;
      }

      60% {
        transform: scale(1.2);
        fill: var(--fill);
      }
    }
  </style>

<style>
        /* Style the Image Used to Trigger the Modal */
        img {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        img:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        #image-viewer {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .modal-content {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        #image-viewer .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        #image-viewer .close:hover,
        #image-viewer .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
    </style>
</head>