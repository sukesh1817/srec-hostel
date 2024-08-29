
    <?php
    // respond to bad request with status code 401 .
    http_response_code(401);
    echo '{
    "message":"Request not valid"
    }';
    ?>
