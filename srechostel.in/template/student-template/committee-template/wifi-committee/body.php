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