<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>@yield('title')</title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('frontend/assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Stylesheets -->

    <link href="{{ asset('frontend/assets/css/font-awesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/flaticon.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/color/theme-color.css') }}" id="jssDefault" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/switcher-style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">

</head>


<!-- page wrapper -->

<body>

    <div class="boxed_wrapper">

      @include('layouts.site.header')
      
      @yield('content')
      
      @include('layouts.site.footer')


        <!--Scroll to top-->
        <button class="scroll-top scroll-to-target" data-target="html">
            <span class="fal fa-angle-up"></span>
        </button>
    </div>


    <!-- jequery plugins -->
    <script src="{{ asset('frontend/assets/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/validation.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/appear.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jQuery.style.switcher.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/nav-tool.js') }}"></script>

    <!-- main-js -->
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>

    <script>
        // Function to fetch and display the visitor count
        function getVisitorCount() {
          // Send an AJAX request to the PHP script that returns the visitor count
          fetch('visitor_count.php')
            .then(response => response.json())
            .then(data => {
              // Display the visitor count on the page
              document.getElementById('visitor-count').innerText = 'Visitor Count: ' + data.visitorCount;
            })
            .catch(error => console.error('Error fetching visitor count:', error));
        }
    
        // Fetch the count as soon as the page loads
        window.onload = getVisitorCount;
    </script>

    <script>
      // Function to generate a random two-digit addition captcha
      function generateCaptcha() {
        const num1 = Math.floor(Math.random() * 90) + 10; // Random number between 10 and 99
        const num2 = Math.floor(Math.random() * 90) + 10; // Random number between 10 and 99
        const captchaSum = num1 + num2;

        // Display the captcha problem on the form
        document.getElementById('captchaProblem').textContent = `${num1} + ${num2} = ?`;

        // Store the correct answer in a hidden field for later validation
        document.getElementById('captchaAnswer').value = captchaSum;
      }

      // Validate the captcha when the form is submitted
      function validateForm(event) {
        const userAnswer = document.getElementById('userCaptchaAnswer').value;
        const correctAnswer = document.getElementById('captchaAnswer').value;

        if (parseInt(userAnswer) !== parseInt(correctAnswer)) {
          alert("Incorrect captcha answer. Please try again.");
          event.preventDefault(); // Prevent form submission
        }
      }

      // Call generateCaptcha on page load
      window.onload = generateCaptcha;
    </script>

    <script>
      $(document).ready(function () {
          $('#contact-form').on('submit', function (e) {
              // Prevent the form submission initially
              e.preventDefault();

              // Check if the form is valid
              if ($('#contact-form').valid()) {
                  const userAnswer = document.getElementById('userCaptchaAnswer').value;
                  const correctAnswer = document.getElementById('captchaAnswer').value;

                  if (parseInt(userAnswer) !== parseInt(correctAnswer)) {
                      alert("Incorrect captcha answer. Please try again.");
                      e.preventDefault(); // Prevent form submission
                      return false;
                  }
                  $('#submit-button').prop('disabled', true);
                  $('#loader').show();
                  // alert('Form is valid! Proceeding with form submission.');

                  // You can proceed with AJAX or form submission here
                  // Example: 
                  // $(this).submit(); // For regular form submission
                  // Or use AJAX:
                  // $.ajax({ ... });                    
                  $.ajax({
                      url: 'sendemail.php', // PHP script to handle the request
                      type: 'POST',
                      data: $(this).serialize(), // Serialize form data
                      success: function (response) {
                          // Hide loader and enable button
                          $('#loader').hide();
                          $('#submit-button').prop('disabled', false);

                          alert(response); // Show success or error message from PHP
                      },
                      error: function () {
                          // Hide loader and enable button
                          $('#loader').hide();
                          $('#submit-button').prop('disabled', false);

                          alert('An error occurred while sending the message.');
                      }
                  });
              } else {
                  // alert('Form is not valid. Please fill out all required fields correctly.');
                  return false;
              }
          });
      });

    </script>

</body><!-- End of .page_wrapper -->

</html>