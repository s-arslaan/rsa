<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>RSA Algorithm</title>
  <style>
    .nav-pills .nav-item .nav-link {
      color: white;
    }

    .nav-pills .nav-item .nav-link.active {
      background-color: #DC3545;
    }
  </style>
</head>

<body class="bg-dark text-white">

  <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: black;">
    <div class="container-fluid">

      <ul class="nav nav-pills position-relative top-50 start-50 translate-middle-x" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link m-2 px-3 active" id="pills-encrypt-tab" data-bs-toggle="pill" data-bs-target="#pills-encrypt" type="button" role="tab" aria-controls="pills-encrypt" aria-selected="true">Encrypter</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link m-2 px-3" id="pills-decrypt-tab" data-bs-toggle="pill" data-bs-target="#pills-decrypt" type="button" role="tab" aria-controls="pills-decrypt" aria-selected="false">Decrypter</button>
        </li>
      </ul>

    </div>
  </nav>


  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-encrypt" role="tabpanel" aria-labelledby="pills-encrypt-tab">
      <!-- THIS IS ENCRYPT -->
      <div class="container mt-3">
        <div class="row">
          <div class="col-12 text-center">
            <h1>RSA Encrypter</h1>
          </div>
        </div>
        <div class="row my-5">
          <div class="col-6">
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="p_val_enc" class="form-label">Enter P</label>
                  <input type="number" class="form-control" id="p_val_enc" placeholder="Prime Number">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="q_val_enc" class="form-label">Enter Q</label>
                  <input type="number" class="form-control" id="q_val_enc" placeholder="Prime Number">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="string_enc" class="form-label">Enter String for Encryption</label>
              <input type="text" class="form-control" id="string_enc" placeholder="Text">
            </div>
            <button class="btn btn-danger mt-3" onclick="encrypt();" id="encrypt">Encrypt!</button>
          </div>
          <div class="col-6 px-5">
            <div class="card border" style="background-color:black;">
              <div class="card-body">
                <h5 class="card-title">Calculations</h5>
                <h6 class="card-subtitle mt-3 mb-2 text-danger" id="enc_heading">Card subtitle</h6>
                <p class="card-text" id="enc_calculation">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="tab-pane fade" id="pills-decrypt" role="tabpanel" aria-labelledby="pills-decrypt-tab">
      <!-- THIS IS DECRYPT -->
      <div class="container mt-3">
        <div class="row">
          <div class="col-12 text-center">
            <h1>RSA Decrypter</h1>
          </div>
        </div>
        <div class="row my-5">
          <div class="col-6">
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="p_val_dec" class="form-label">Enter P</label>
                  <input type="number" class="form-control" id="p_val_dec" placeholder="Prime Number">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="q_val_dec" class="form-label">Enter Q</label>
                  <input type="number" class="form-control" id="q_val_dec" placeholder="Prime Number">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="string_dec" class="form-label">Enter Values for Decryption</label>
              <input type="text" class="form-control" id="string_dec" placeholder="comma separated values">
            </div>
            <button class="btn btn-danger mt-3" onclick="decrypt();" id="encrypt">Encrypt!</button>
          </div>
          <div class="col-6 px-5">
            <div class="card border" style="background-color:black;">
              <div class="card-body">
                <h5 class="card-title">Calculations</h5>
                <h6 class="card-subtitle mt-3 mb-2 text-danger" id="enc_heading">Card subtitle</h6>
                <p class="card-text" id="enc_calculation">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script>
    const encrypt = () => {
      let p = document.getElementById("p_val_enc").value;
      let q = document.getElementById("q_val_enc").value;
      let str = document.getElementById("string_enc").value;
      console.log(p);
      console.log(q);
      console.log(str);
    };
    
    const decrypt = () => {
      let p = document.getElementById("p_val_dec").value;
      let q = document.getElementById("q_val_dec").value;
      let str = document.getElementById("string_dec").value;
      console.log(p);
      console.log(q);
      console.log(str);
    };

    // document.getElementById("submit").addEventListener("click", function (event) {
    //   event.preventDefault();
    //   let p = document.getElementById("p_val_enc").value;
    //   let q = document.getElementById("q_val_enc").value;
    //   console.log(p);
    //   console.log(q);
    // });

  </script>
</body>

</html>