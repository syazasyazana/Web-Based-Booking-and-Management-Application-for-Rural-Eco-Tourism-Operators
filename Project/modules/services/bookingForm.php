<?php
include '../../config/config.php';  // Include database configuration

// Fetch all services from the database
$serviceQuery = $conn->query("SELECT * FROM polumpong.services");


if ($serviceQuery->num_rows === 0) {
    echo "No services found.";
    exit;
}

// Start of HTML output
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>POLUMPONG BOOKING SITE</title>
	<link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="../../css/style.css" rel='stylesheet' type='text/css' />
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
            background-image: url('../../images/polumpong.img');
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

		#serviceSelect {
        color: black;
    }

        .navbar .login-icon:hover {
            color: #00d9ff;
        }
		

		</style>
	<script
		type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<script src="../../js/jquery.min.js"></script>
	<script type="text/javascript">
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
				if (!$clicked.parents().hasClass("dropdown"))
					$(".dropdown dd ul").hide();
			});


			$("#flagSwitcher").click(function () {
				$(".dropdown img.flag").toggleClass("flagvisibility");
			});
		});
	</script>
	<!----details-product-slider--->
	<!-- Include the Etalage files -->
	<link rel="stylesheet" href="../../css/etalage.css">
	<script src="../../js/jquery.etalage.min.js"></script>
	<!-- Include the Etalage files -->
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
			// This is for the dropdown list example:
			$('.dropdownlist').change(function () {
				etalage_show($(this).find('option:selected').attr('class'));
			});

		});
	</script>
	<!----//details-product-slider--->
	<body>
    <div class="navbar">
        <div class="logo">Explore</div>
        <div class="nav-links">
            <a href="home.html">Home</a>
            <a href="#">Destination</a>
            <a href="#">Contact Us</a>
            <a href="#">Blog</a>
        </div>
        <a href="login.php" class="login-icon">&#128100;</a>
    </div>
</head>

<body>
	
						<!----search-scripts---->
						<script src="js/classie.js"></script>
						<script src="js/uisearch.js"></script>
						<script>
							new UISearch(document.getElementById('sb-search'));
						</script>
						<ul class="icon1 sub-icon1 profile_img">
							<li><a class="active-icon c1" href="#"> </a>
								<ul class="sub-icon1 list">
									<div class="product_control_buttons">
										<a href="#"><img src="../../images/edit.png" alt="" /></a>
										<a href="#"><img src="../../images/close_edit.png" alt="" /></a>
									</div>
									<div class="clear"></div>
									<li class="list_img"><img src="../../images/1.jpg" alt="" /></li>
									<li class="list_desc">
										<h4><a href="#">velit esse molestie</a></h4><span class="actual">1 x
											$12.00</span>
									</li>
									<div class="login_buttons">
										<div class="check_button"><a href="checkout.html">Check out</a></div>
										<div class="login_button"><a href="login.html">Login</a></div>
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
								</ul>
							</li>
						</ul>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
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
										<img class="etalage_thumb_image" src="../../images/3.jpg" />
										<img class="etalage_source_image" src="../../images/3.jpg" />
									</a>
								</li>
								<li>
									<img class="etalage_thumb_image" src="../../images/4.jpg" />
									<img class="etalage_source_image" src="../../images/4.jpg" />
								</li>
								<li>
									<img class="etalage_thumb_image" src="../../images/5.jpg" />
									<img class="etalage_source_image" src="../../images/5.jpg" />
								</li>
								<li>
									<img class="etalage_thumb_image" src="../../images/6.jpg" />
									<img class="etalage_source_image" src="../../images/6.jpg" />
								</li>
								<li>
									<img class="etalage_thumb_image" src="../../images/7.jpg" />
									<img class="etalage_source_image" src="../../images/7.jpg" />
								</li>
								<li>
									<img class="etalage_thumb_image" src="../../images/8.jpg" />
									<img class="etalage_source_image" src="../../images/8.jpg" />
								</li>
								<li>
									<img class="etalage_thumb_image" src="../../images/9.jpg" />
									<img class="etalage_source_image" src="../../images/9.jpg" />
								</li>
							</ul>
						</div>
						<!-- end product_slider -->
						<div class="single_right">
    <h3>book now!!</h3>
    <p class="m_10">We offer a variety of exciting services for You
        to enjoy!! Choose the one that suits you best: Swimming, Campsite, Rafting,
        Kayaking, BBQ Parties, and Fishing. Select the services you'd like, and we'll take
        care of the rest!</p>
    <h4 class="m_12"style="color: white;" >Select Your Services</h4>
<select id="serviceSelect" style="width: 200px; color: black;"></select>
    
    <div>
    <h4 class="m_12" style="color: white;"><br>Additional Services</h4>
    <label>
        <input type="checkbox" class="additionalService" id="swimming" value="Swimming" data-price="20"> Swimming ($20)
    </label><br>
    <label>
        <input type="checkbox" class="additionalService" id="campsite" value="Campsite" data-price="50"> Campsite ($50)
    </label><br>
    <label>
        <input type="checkbox" class="additionalService" id="rafting" value="Rafting" data-price="30"> Rafting ($30)
    </label><br>
    <label>
        <input type="checkbox" class="additionalService" id="kayaking" value="Kayaking" data-price="25"> Kayaking ($25)
    </label><br>
    <label>
        <input type="checkbox" class="additionalService" id="bbq" value="BBQ Parties" data-price="40"> BBQ Parties ($40)
    </label><br>
    <label>
        <input type="checkbox" class="additionalService" id="fishing" value="Fishing" data-price="15"> Fishing ($15)
    </label><br>
</div>

    
    <ul class="product-colors">
        <div class="single_right">
            <h4 class="m_12" style="color: white;"><br>Choose Start Date</h4>
            <input type="date" id="startDate" style="width: 200px; color: black;" />
        </div>
        <div class="single_right">
            <h4 class="m_12" style="color: white;"><br>Choose End Date</h4>
            <input type="date" id="endDate" style="width: 200px;color: black;" />
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
<div class="clear"> </div>
</div>
<div class="col-md-3">
    <div class="box-info-product">
        <p class="price2">$0.00</p>
        <button type="submit" name="Submit" class="exclusive">
            <span>Add to cart</span>
        </button>
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
            $('.price2').text($${totalPrice.toFixed(2)});
        }

        $.ajax({
            url: "admin/api.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    let options = '<option value="">Select Service</option>';
                    response.data.forEach(function (service) {
                        options += `
            <option value="${service.service_id}" data-price="${service.price}">
              ${service.name}
            </option>`;
                    });
                    $("#serviceSelect").html(options);
                } else {
                    console.error(response.message);
                }
            },
            error: function () {
                console.error("Failed to fetch services.");
            }
        });

        $("#serviceSelect").on("change", function () {
            const selectedOption = $(this).find(":selected");
            dailyPrice = parseFloat(selectedOption.data("price")) || 0;
            $('.price2').text($${dailyPrice.toFixed(2)});
            updatePrice();
        });

        $(".additionalService").on("change", function () {
            additionalServicesPrice = 0;
            $(".additionalService:checked").each(function () {
                additionalServicesPrice += parseFloat($(this).data("price")) || 0;
            });
            updatePrice();
        });

        $("#startDate, #endDate").on("change", function () {
            updatePrice();
        });
    });
</script>

</body>

</html>