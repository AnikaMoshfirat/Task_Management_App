<!DOCTYPE html>
<html>

  <head>
    <title>Forgot Password | TM</title>

    <link rel="stylesheet" href="../../asset/css/forgotPasswordStyle.css">
    <link rel="icon" type="image/png" href="../../asset/imgs/icon.png">

  </head>

  <body>
    <div class="fp-container">
      <form id="fpForm">
        <h2>Forgot Password</h2>
        <p>Please enter your email or phone number to reset your password</p>

        <div class="input-group">
          <label for="fpInput">Email or Phone</label>
          <input type="text" id="fpInput" required />
        </div>

        <button type="submit">Submit</button>

        <p class="message" id="fpMessage"></p>
      </form>
    </div>

    <script src="../../asset/js/forgotPassword.js"></script>
  </body>

</html>
