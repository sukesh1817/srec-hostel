<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit complaint</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.3/examples/dropdowns/dropdowns.css">
    <link  rel="icon" type="image/x-icon" href="/images/icons/complaint-icon.png">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


 <style>
    body {
      font-family: "Poppins", sans-serif;
      font-weight: 400;
      font-style: normal;
    }


  </style> 
   <style>
     strong {
            font-weight: 600;
        }

        .notification {
            width: 360px;
            padding: 15px;
            background-color: #ececec;
            border-radius: 16px;
            position: fixed;
            bottom: 15px;
            left: 15px;
            transform: translateY(200%);
            animation: noti 2s forwards alternate ease-in;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .notification.hidden {
            opacity: 0;
            transform: translateY(200%);
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .notification-title {
            font-size: 16px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .notification-close {
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F0F2F5;
            font-size: 14px;
        }

        .notification-container {
            display: flex;
            align-items: flex-start;
        }

        .notification-media {
            position: relative;
        }

        .notification-user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 60px;
            object-fit: cover;
        }

        .notification-reaction {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 30px;
            color: white;
            background-image: linear-gradient(45deg, #0070E1, #14ABFE);
            font-size: 14px;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .notification-content {
            width: calc(100% - 60px);
            padding-left: 20px;
            line-height: 1.2;
        }

        .notification-text {
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 50px;
        }

        .notification-timer {
            color: #1876F2;
            font-weight: 600;
            font-size: 14px;
        }

        .notification-status {
            position: absolute;
            right: 15px;
            top: 50%;
            width: 15px;
            height: 15px;
            background-color: #1876F2;
            border-radius: 50%;
        }

        @keyframes noti {
            50% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(0);
            }
        }
  </style>
</head>