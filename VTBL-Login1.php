<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vision Tea Brokers Management System</title>
    <link rel="stylesheet" type="text/css" href="VTBL-login1.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .error {
            color: red;
            font-weight: bold;
        }
        #forgot-password-modal {
            display: none;
            position: fixed;
            top: 75%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: grey;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;

        }
        #modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <div style="-webkit-animation: animatezoom 0.6s; animation: animatezoom 0.6s;">
        <span style="transform: scale(0.8);" onclick="history.go(-1)" class="close">
            <i class='bx bx-log-out'></i>
        </span>
        <div class="loginHeader">
            <h1>VISION TEA BROKERS LIMITED</h1>
            <p>Brokerage Management System</p>
        </div>
        <div class="loginBody">
            <form action="login1.php" method="post">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php } ?>
                <div class="loginInputCont">
                    <label for="user_name">Username</label>
                    <input id="user_name" placeholder="Enter username" name="user_name" type="text" required />
                </div>
                <div class="loginInputCont">
                    <label for="password">Password</label>
                    <input id="password" placeholder="Enter password" name="password" type="password" required />
                </div>
                <div class="loginButtonCont">
                    <button type="submit">Login</button>
                </div>
                <div class="containerCancel-Forget">
                    <button type="button" onclick="history.go(-1)" class="cancelbtn">Cancel</button>
                    <span class="PswForget">Forgot <a href="#" id="forgot-password-link">password?</a></span>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div id="modal-overlay"></div>

    <!-- Forgot Password Modal -->
    <div id="forgot-password-modal">
        <h3>Forgot Password</h3>
        <form action="forgot_password.php" method="post">
            <div>
                <label for="email">Enter your email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required />
            </div>
            <div>
                <button type="submit">Reset</button>
                <button type="button" id="cancel-modal">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            // Show the modal and overlay
            $('#forgot-password-link').on('click', function (e) {
                e.preventDefault();
                $('#modal-overlay, #forgot-password-modal').fadeIn();
            });

            // Hide the modal and overlay
            $('#cancel-modal, #modal-overlay').on('click', function () {
                $('#modal-overlay, #forgot-password-modal').fadeOut();
            });
        });
    </script>
</body>
</html>
