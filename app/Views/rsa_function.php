<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>RSA Algorithm</title>
</head>
<body class="bg-dark text-white">

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
                          <label for="p_val" class="form-label">Enter P</label>
                          <input type="number" class="form-control" id="p_val" placeholder="Prime Number">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                          <label for="q_val" class="form-label">Enter Q</label>
                          <input type="number" class="form-control" id="q_val" placeholder="Prime Number">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                  <label for="string_enc" class="form-label">Enter String for Encryption</label>
                  <input type="text" class="form-control" id="string_enc">
                </div>
                <button class="btn btn-danger mt-3" onclick="enc();" id="encrypt">Encrypt!</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
const enc = () => {
  let p = document.getElementById("p_val").value;
  let q = document.getElementById("q_val").value;
  let str = document.getElementById("string_enc").value;
  console.log(p);
  console.log(q);
  console.log(str);
};

// document.getElementById("submit").addEventListener("click", function (event) {
//   event.preventDefault();
//   let p = document.getElementById("p_val").value;
//   let q = document.getElementById("q_val").value;
//   console.log(p);
//   console.log(q);
// });

const encrypt = (msg) => {}
const decrypt = (values) => {}

</script>
</body>
</html>