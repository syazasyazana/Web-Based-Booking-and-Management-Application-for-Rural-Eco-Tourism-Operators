<?php
include 'config/config.php'; // Include database configuration

// Fetch all services from the database
$serviceQuery = $conn->query("SELECT * FROM polumpong.services");

if ($serviceQuery->num_rows === 0) {
    echo "No services found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>POLUMPONG BOOKING SITE</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('images/polumpong.img');
            background-size: cover;
            background-position: center;
            color: white;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2px 30px;
            background-color: rgba(0, 0, 0, 0.6);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .navbar .nav-links {
            display: flex;
            gap: 10px;
        }

        .navbar .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #00d9ff;
        }

        .navbar .login-icon {
            font-size: 32px;
            color: black;
            transition: color 0.3s ease;
        }

        .navbar .login-icon:hover {
            color: #00d9ff;
        }
        .btn-available {
    background-color: #4CAF50; /* Green */
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: default;
}

.btn-unavailable {
    background-color: #f44336; /* Red */
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: default;
    opacity: 0.8; /* Slightly faded for Sold Out */
}

        #serviceSelect {
            color: black;
        }
		
		
    </style>
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".dropdown img.flag").addClass("flagvisibility");

            $(".dropdown dt a").click(function () {
                $(".dropdown dd ul").toggle();
            });

            $(".dropdown dd ul li a").click(function () {
                var text = $(this).html();
                $(".dropdown dt a span").html(text);
                $(".dropdown dd ul").hide();
                $("#result").html("Selected value is: " + getSelectedValue("sample"));
            });

            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).bind('click', function (e) {
                var $clicked = $(e.target);
                if (!$clicked.parents().hasClass("dropdown")) {
                    $(".dropdown dd ul").hide();
                }
            });

            $("#flagSwitcher").click(function () {
                $(".dropdown img.flag").toggleClass("flagvisibility");
            });
        });
    </script>
    <link rel="stylesheet" href="css/etalage.css">
    <script src="js/jquery.etalage.min.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            $('#etalage').etalage({
                thumb_image_width: 300,
                thumb_image_height: 400,
                show_hint: true,
                click_callback: function (image_anchor, instance_id) {
                    alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
                }
            });

            $('.dropdownlist').change(function () {
                etalage_show($(this).find('option:selected').attr('class'));
            });
        });
// Update hidden fields before form submission
        $("#addToCartButton").click(function () {
            const selectedService = $("#serviceSelect").find(":selected");
            const selectedServiceId = selectedService.val();
            const selectedServicePrice = $('.price2').text().replace('$', '');

            // Set the values of hidden inputs
            $("#service_id").val(selectedServiceId);
            $("#total_price").val(selectedServicePrice);
        });
    </script>
</head>

<body>
    <div class="navbar">
        <div class="logo">Explore</div>
        <div class="nav-links">
<a href="dashboard.php">Home</a>
            <a href="modules/services/serviceListing.php">Services</a>
            <a href="modules/faq/faq.php">FAQ</a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="profile.php">My Profile</a>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="#" class="logout" onclick="confirmLogout(event)">Logout</a>
        <?php endif; ?>
    </div>
	
	


    <div class="main">
        <div class="shop_top">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 single_left">
                        <div class="single_image">
                            <ul id="etalage">
                                <li>
                                    <a href="optionallink.html">
                                        <img class="etalage_thumb_image" src="images/3.jpg" />
                                        <img class="etalage_source_image" src="images/3.jpg" />
                                    </a>
                                </li>
                                <li>
                                    <img class="etalage_thumb_image" src="images/4.jpg" />
                                    <img class="etalage_source_image" src="images/4.jpg" />
                                </li>
                                <li>
                                    <img class="etalage_thumb_image" src="images/5.jpg" />
                                    <img class="etalage_source_image" src="images/5.jpg" />
                                </li>
                                <li>
                                    <img class="etalage_thumb_image" src="images/6.jpg" />
                                    <img class="etalage_source_image" src="images/6.jpg" />
                                </li>
                                <li>
                                    <img class="etalage_thumb_image" src="images/7.jpg" />
                                    <img class="etalage_source_image" src="images/7.jpg" />
                                </li>
                                <li>
                                    <img class="etalage_thumb_image" src="images/8.jpg" />
                                    <img class="etalage_source_image" src="images/8.jpg" />
                                </li>
                                <li>
                                    <img class="etalage_thumb_image" src="images/9.jpg" />
                                    <img class="etalage_source_image" src="images/9.jpg" />
                                </li>
                            </ul>
                        </div>

                        <div class="single_right">
                            <h3>Book Now!!</h3>
                            <p class="m_10">We offer a variety of exciting services for you to enjoy! Choose the one that suits you best: Swimming, Campsite, Rafting, Kayaking, BBQ Parties, and Fishing. Select the services you'd like, and we'll take care of the rest!</p>
                            

                          <div>
                          <h4 class="m_12" style="color: white;"><br>Choose Services</h4>
<?php
// Fetch services from the additional_services table
$servicesQuery = $conn->query("SELECT * FROM additional_services"); // Adjust table name as needed

if ($servicesQuery->num_rows > 0) {
    while ($service = $servicesQuery->fetch_assoc()) {
        // Get the availability status
        $isAvailable = ($service['availability'] === 'available');
        $availabilityText = $isAvailable ? 'Available' : 'Sold Out';
        $buttonClass = $isAvailable ? 'btn-available' : 'btn-unavailable'; // Add classes for styling

        // Display the service with a checkbox and a styled button for availability
        echo '<label style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">';
        echo '<input type="checkbox" class="additionalService" ';
        echo 'id="service_' . $service['service_id'] . '" '; // Use unique IDs for inputs
        echo 'value="' . htmlspecialchars($service['service_name']) . '" '; // Sanitize output
        echo 'data-price="' . htmlspecialchars($service['service_price']) . '" ';
        echo $isAvailable ? '' : 'disabled';  // Disable checkbox if not available
        echo '>';
        echo '<span style="margin-right: 10px;">' . htmlspecialchars($service['service_name']) . ' ($' . htmlspecialchars($service['service_price']) . ')</span>';
        echo '<button type="button" class="' . $buttonClass . '" disabled>';
        echo $availabilityText;
        echo '</button>';
        echo '</label>';
    }
} else {
    echo '<p style="color: white;">No services available at the moment.</p>';
}
?>

                            <ul class="product-colors">
                                <div class="single_right">
                                    <h4 class="m_12" style="color: white;"><br>Choose Start Date</h4>
                                    <input type="date" id="startDate" style="width: 200px; color: black;" />
                                </div>
                                <div class="single_right">
                                    <h4 class="m_12" style="color: white;"><br>Choose End Date</h4>
                                    <input type="date" id="endDate" style="width: 200px; color: black;" />
                                </div>
                                <div class="single_right">
                                    <h4 class="m_12" style="color: white;"><br>Check-in Time</h4>
                                    <input type="time" id="checkInTime" style="width: 200px; color: black;" />
                                </div>
                                <div class="single_right">
                                    <h4 class="m_12" style="color: white;"><br>Check-out Time</h4>
                                    <input type="time" id="checkOutTime" style="width: 200px; color: black;" />
                                </div>
                            </ul>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; margin-top: 20px; gap: 10px; align-items: flex-start;">
    <div style="display: flex; flex-direction: column; align-items: center; padding: 15px; border: 1px solid white; border-radius: 10px; background-color: rgba(255, 255, 255, 0.1); width: 300px;">
        <p class="price2" style="font-size: 30px; margin-bottom: 10px;">$0.00</p>
<form action="modules/payment_module/payment_new.php" method="post" style="margin: 0;">
    <input type="hidden" name="total_price" id="total_price" value="">
    <input type="hidden" name="selected_services" id="selected_services" value="">
    <button type="submit" name="Submit" class="exclusive" id="addToCartButton" style="background-color: #00d9ff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
        <span>Add to Cart</span>
    </button>
</form>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    $(document).ready(function () {
        let dailyPrice = 0;
        let additionalServicesPrice = 0;

        function updatePrice() {
            const startDateVal = $('#startDate').val();
            const endDateVal = $('#endDate').val();
            let totalDays = 0;

            if (startDateVal && endDateVal) {
                const start = new Date(startDateVal);
                const end = new Date(endDateVal);
                const diffTime = end.getTime() - start.getTime();
                totalDays = diffTime / (1000 * 3600 * 24);

                if (totalDays < 0) {
                    totalDays = 0;
                }
            }

            const totalPrice = (dailyPrice + additionalServicesPrice) * (totalDays > 1 ? totalDays : 1);
            $('.price2').text(`$${totalPrice.toFixed(2)}`);
        }

        // Fetch all services and populate checkboxes with price and availability
        $.ajax({
            url: "admin/api.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    let additionalServicesHtml = '';
                    response.data.forEach(function (service) {
                        // Add each service to the additional services section with availability
                        additionalServicesHtml += `
                            <label>
                                <input type="checkbox" class="additionalService" id="${service.service_id}" value="${service.service_name}" data-price="${service.service_price}" data-availability="${service.availability}">
                                ${service.service_name} ($${service.service_price}) - ${service.availability === 'available' ? 'Available' : 'Sold Out'}
                            </label><br>
                        `;
                    });
                    $(".additional-services").html(additionalServicesHtml);  // Insert the checkboxes into the container
                } else {
                    console.error(response.message);
                }
            },
            error: function () {
                console.error("Failed to fetch services.");
            }
        });

        // Update daily price when a service is selected
        $(".additionalService").on("change", function () {
            additionalServicesPrice = 0;
            $(".additionalService:checked").each(function () {
                additionalServicesPrice += parseFloat($(this).data("price")) || 0;
            });
            updatePrice();
        });

        // Update price when start or end date changes
        $("#startDate, #endDate").on("change", function () {
            updatePrice();
        });

        // Update main price when a primary service is selected
        $("#serviceSelect").on("change", function () {
            const selectedOption = $(this).find(":selected");
            dailyPrice = parseFloat(selectedOption.data("price")) || 0;
            $('.price2').text(`$${dailyPrice.toFixed(2)}`);
            updatePrice();
        });
                      // Update hidden fields before form submission
                      $("#addToCartButton").click(function () {
                          const totalPrice = $('.price2').text().replace('$', ''); // Extract the price value
                          $("#total_price").val(totalPrice); // Set the hidden input field
                      });
                      $("#addToCartButton").click(function () {
                          const selectedServices = [];
                          
                          // Collect all checked service values
                          $(".additionalService:checked").each(function () {
                              selectedServices.push($(this).val());
                          });

                          // Store the selected services as a comma-separated string in the hidden input field
                          $("#selected_services").val(selectedServices.join(','));
                      });

    });
</script>
</body>

</html>
