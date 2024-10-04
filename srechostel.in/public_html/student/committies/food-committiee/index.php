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

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-picture">
                    <img src="https://via.placeholder.com/120" alt="Profile Picture">
                    <h3>Ajay M</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Leader Information</h4>
                    </div>
                    <div class="row mt-2 border-bottom">
                        <div class="col-md-6"><label class="labels">Name</label>
                            <p class="details">Ajay M</p>
                        </div>
                        <div class="col-md-6"><label class="labels">Year of study</label>
                            <p class="details">III</p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="border-bottom">
                            <div class="col-md-12"><label class="labels">Degree</label>
                                <p class="details">B.Tech</p>
                            </div>
                            <div class="col-md-12"><label class="labels">Branch</label>
                                <p class="details">IT</p>
                            </div>
                        </div>
                        <div class="border-bottom mt-2">
                            <div class="col-md-12"><label class="labels">Men hostel</label>
                                <p class="details">I</p>
                            </div>
                            <div class="col-md-12"><label class="labels">Room no</label>
                                <p class="details">203</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <h4>Leader of the Week</h4>
                    <label class="labels mb-3" style="font-weight: 500;">Your Ratings</label>
                    <div class="rating">
                        <input type="radio" id="star-5" name="star-radio" value="5">
                        <label for="star-5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path pathLength="360"
                                    d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                </path>
                            </svg>
                        </label>
                        <input type="radio" id="star-4" name="star-radio" value="4">
                        <label for="star-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path pathLength="360"
                                    d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                </path>
                            </svg>
                        </label>
                        <input type="radio" id="star-3" name="star-radio" value="3">
                        <label for="star-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path pathLength="360"
                                    d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                </path>
                            </svg>
                        </label>
                        <input type="radio" id="star-2" name="star-radio" value="2">
                        <label for="star-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path pathLength="360"
                                    d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                </path>
                            </svg>
                        </label>
                        <input type="radio" id="star-1" name="star-radio" value="1">
                        <label for="star-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path pathLength="360"
                                    d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                </path>
                            </svg>
                        </label>
                    </div>
                    <div class="comment-box mt-3">
                        <label class="labels mb-3" style="font-weight: 500;">Your Opinion</label>
                        <input type="text" placeholder="Share your opinion">
                    </div>
                    <div class="mt-3">
                        <button class="submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="achievements">
            <h2>Leader Achievements</h2>
            <div class="grid images">
                <img class="photo" src="https://via.placeholder.com/150" alt="Achievement">
                <img src="https://via.placeholder.com/150" alt="Achievement">
                <img src="https://via.placeholder.com/150" alt="Achievement">
                <img src="https://via.placeholder.com/150" alt="Achievement">
                <img src="https://via.placeholder.com/150" alt="Achievement">
                <img src="https://via.placeholder.com/150" alt="Achievement">
                <img src="https://via.placeholder.com/150" alt="Achievement">
                <img src="https://via.placeholder.com/150" alt="Achievement">
            </div>
        </div>
    </div>

    <div id="image-viewer">
    <button type="button" class="btn-close btn-close-white close" aria-label="Close"></button>
    <img class="modal-content" id="full-image">
    </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(".images .photo").click(function () {
    $("#full-image").attr("src", $(this).attr("src"));
    $('#image-viewer').show();
    $(".navbar").hide()
  });

  $("#image-viewer .close").click(function () {
    $('#image-viewer').hide();
    $(".show").hide()
    $(".navbar").show()

  });
</script>

</html>