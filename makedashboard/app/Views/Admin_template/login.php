<style type="text/css">
  body{
  height: 100vh;
  background: #000 !important;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.card{
  overflow: hidden;
  border: 0 !important;
  border-radius: 20px !important;
  background: #000 !important;
  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.img-left{
  width: 45%;
  background: url('img2.png') center;
  background-size: cover;
}

.card-body{
  padding: 2rem;
}

.title{
  margin-bottom: 2rem;
}

.form-input{
  position: relative;
}

.form-input input{
  width: 100%;
  height: 45px;
  padding-left: 40px;
  margin-bottom: 20px;
  box-sizing: border-box;
  box-shadow: none;
  border: 1px solid #00000020;
  border-radius: 50px;
  outline: none;
  background: transparent;
}

.form-input span{
  position: absolute;
  top: 10px;
  padding-left: 15px;
  color: #ffae00;
}

.form-input input::placeholder{
  color: black;
  padding-left: 0px;
}

 .form-input input{
  border: 2px solid #ffae00 !important;
}

.form-input input::placeholder{
  color: #bbc0c5;
}

.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before{
  background-color: #ffae00 !important;
  border: 0px;
}

.form-box button[type="submit"]{
  margin-top: 10px;
  border: none;
  cursor: pointer;
  border-radius: 50px;
  background: #ffae00;
  color: #fff;
  font-size: 90%;
  font-weight: bold;
  letter-spacing: .1rem;
  transition: 0.5s;
  padding: 12px;
}

/*.form-box button[type="submit"]:hover{
  background: #bbc0c5 !important;
}*/

.forget-link, .register-link{
  color: #ffae00;
  font-weight: bold;
}

.forget-link:hover, .register-link:hover{
  color:#bbc0c5;
  text-decoration: none;
}

.form-box .btn-social{
  color: white !important;
  border: 0;
  font-weight: bold;
}

.form-box .btn-facebook{
  background: #4866a8;
}

.form-box .btn-google{
  background: #da3f34;
}

.form-box .btn-twitter{
  background: #33ccff;
}

.form-box .btn-facebook:hover{
  background: #3d578f;
}

.form-box .btn-google:hover{
  background: #bf3b31;
}

.form-box .btn-twitter:hover{
  background: #2eb7e5;
}

#logintitle{
   color: #bbc0c5;
}

.form-input input:focus{
  color: #bbc0c5;
}
.fa-key:before,.fa-envelope-o:before{
    content: "\f084";
    font-size: 1.4rem;
}


</style>

<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="row px-3">
      <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
        <div class="img-left d-none d-md-flex"></div>

        <div class="card-body">
          <h4 id="logintitle" class="title text-center mt-4">
            Login into account
          </h4>
          <form class="form-box px-3" action="Index">
            <div class="form-input">
              <span><i class="fa fa-envelope-o"></i></span>
              <input type="email" name="" placeholder="Email Address" tabindex="10" required>
            </div>
            <div class="form-input">
              <span><i class="fa fa-key"></i></span>
              <input type="password" name="" placeholder="Password" required>
            </div>

            <div class="mb-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" style="background-color:#bbc0c5;" class="custom-control-input" id="cb1" name="">
                <label class="custom-control-label" style="color:#bbc0c5 ;" for="cb1">Remember me</label>
              </div>
            </div>

            <div class="mb-3">
              <button type="submit" class="btn btn-block text-uppercase">
                Login
              </button>
            </div>

            <div class="text-right">
              <a href="#"  class="forget-link">
                Forget Password?
              </a>
            </div>

            <div class="text-center mb-3">

            </div>

            <!-- <div class="row mb-3">
              <div class="col-4">
                <a href="#" class="btn btn-block btn-social btn-facebook">
                  facebook
                </a>
              </div>

              <div class="col-4">
                <a href="#" class="btn btn-block btn-social btn-google">
                  google
                </a>
              </div>

              <div class="col-4">
                <a href="#" class="btn btn-block btn-social btn-twitter">
                  twitter
                </a>
              </div>
            </div> -->

            <hr class="my-4">

            <div  style="color:#bbc0c5 ;" class="text-center mb-2">
              Don't have an account?
              <a href="#" class="register-link">
                Register here
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>