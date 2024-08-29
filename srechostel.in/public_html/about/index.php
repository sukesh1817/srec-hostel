<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sri Ramakrishna Engineering College</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .header {
            height: 80px;
            /* Adjust height as needed */
            background-color: #FFA500;
            /* Orange color */
            text-align: center;
            line-height: 80px;
            color: #fff;
            font-size: 24px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .container {
            max-width: 960px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #333;
            text-align:center;
            margin-bottom: 20px;
        }

        p {
            line-height: 1.6;
        }

        .contact-info {
            margin-top: 20px;
        }

        .contact-info p {
            margin-bottom: 10px;
        }

        .contact-info h3 {
            margin-bottom: 10px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        .container2 {
            /* max-width: 800px; */
            padding: 20px;
            margin: auto;
            justify-content: center;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease;
        }
    </style>
</head>

<body>
    <div class="header">
        Sri Ramakrishna Engineering College
    </div>
    <div class="container">
        <h1>About Hostel</h1>
        <div class="card">
            <h2 style="color: #FFA500;">Hostel Details</h2>
            <p>Sri Ramakrishna Engineering College (SREC) provides comfortable and secure hostel facilities for both
                boys and girls. The hostels are equipped with modern amenities and are managed by experienced staff to
                ensure a pleasant stay for students.</p>
        </div>
        <div class="card">
            <h2 style="color: #FFA500;">Hostel Amenities</h2>
            <ul style="color:black">
                <li>Wi-Fi enabled throughout the hostel</li>
                <li>Vegetarian and non-vegetarian menu options available</li>
                <li>24-hour security for guest safety</li>
                <li>24-hour generator backup to ensure uninterrupted power supply</li>
                <li>Solar water heater for eco-friendly hot water</li>
                <li>Water purifier to provide clean and safe drinking water</li>
                <li>24-hour ambulance facility for emergencies</li>
                <li>24-hour health center for medical assistance</li>
                <li>Indoor and outdoor games for recreational activities</li>
                <li>In-house store for convenience</li>
                <li>Homely environment to provide a comfortable and welcoming atmosphere, giving guests a feel-at-home
                    experience</li>
            </ul>
        </div>

        <div class="card">
            <h2 style="color:#FFA500;">Contact Information</h2>
            <div class="contact-info">
                <h3>General Enquiries</h3>
                <p>Email: info@srec.ac.in</p>
                <p>Phone: +91 123 456 7890</p>
                <h3>Admissions Enquiries</h3>
                <p>Email: admissions@srec.ac.in</p>
                <p>Phone: +91 987 654 3210</p>
                <h3>Address</h3>
                <p>Sri Ramakrishna Engineering College</p>
                <p>Vattamalaipalayam, N.G.G.O Colony Post</p>
                <p>Coimbatore - 641022</p>
                <p>Tamil Nadu, India</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.add('animated');
            });
        });
    </script>
</body>

</html>